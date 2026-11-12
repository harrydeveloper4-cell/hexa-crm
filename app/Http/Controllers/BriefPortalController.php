<?php

namespace App\Http\Controllers;

use App\Mail\BriefSubmissionReceived;
use App\Models\Adminiy;
use App\Models\BriefFormRequest;
use App\Models\BriefFormSubmission;
use App\Models\Order;
use App\Models\User;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BriefPortalController extends Controller
{
    public function access($token)
    {
        $formRequest = BriefFormRequest::with('client')
            ->where('access_token_hash', hash('sha256', $token))
            ->where('status', 'sent')
            ->where('email_status', 'sent')
            ->first();

        if (!$formRequest || !$formRequest->client || !$formRequest->client->is_active
            || !$formRequest->expires_at || $formRequest->expires_at->isPast()) {
            return response()->view('briefs.expired', [], 410);
        }

        Auth::guard('user')->login($formRequest->client);
        session(['auth_guard' => 'user']);

        return redirect()->route('client.brief.show', ['id' => $formRequest->id]);
    }

    public function dashboard()
    {
        $client = $this->authenticatedClient();
        if (!$client) {
            return redirect()->route('user.login');
        }

        $requests = BriefFormRequest::with('order.brand_details')
            ->where('client_id', $client->id)
            ->where('email_status', 'sent')
            ->orderByDesc('sent_at')
            ->get();

        return view('client.briefs.dashboard', compact('client', 'requests'));
    }

    public function showForm($id)
    {
        $client = $this->authenticatedClient();
        if (!$client) {
            return redirect()->route('user.login');
        }

        $formRequest = BriefFormRequest::with('order.brand_details')->findOrFail($id);
        abort_unless((int) $formRequest->client_id === (int) $client->id, 403);

        if ($formRequest->status === 'submitted') {
            return redirect()->route('client.brief.dashboard')
                ->with('success', 'This brief form has already been submitted.');
        }

        if ($formRequest->status !== 'sent' || !$formRequest->expires_at || $formRequest->expires_at->isPast()) {
            return response()->view('briefs.expired', [], 410);
        }

        $fields = $formRequest->fields_snapshot ?: [];
        $brand = optional($formRequest->order)->brand_details;

        return view('client.briefs.form', compact('client', 'formRequest', 'fields', 'brand'));
    }

    public function submit(Request $request, $id)
    {
        $client = $this->authenticatedClient();
        if (!$client) {
            return redirect()->route('user.login');
        }

        $formRequest = BriefFormRequest::with(['order.brand_details', 'supportPerson'])->findOrFail($id);
        abort_unless((int) $formRequest->client_id === (int) $client->id, 403);

        if ($formRequest->status !== 'sent' || !$formRequest->expires_at || $formRequest->expires_at->isPast()) {
            return response()->view('briefs.expired', [], 410);
        }

        $fields = $formRequest->fields_snapshot ?: [];
        $rules = ['answers' => 'nullable|array'];

        foreach ($fields as $field) {
            $key = 'answers.' . $field['id'];
            $required = !empty($field['is_required']);

            switch ($field['field_type']) {
                case 'file':
                    $rules[$key] = ($required ? 'required' : 'nullable') . '|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,txt|max:10240';
                    break;
                case 'checkbox':
                    $rules[$key] = ($required ? 'required' : 'nullable') . '|array';
                    $rules[$key . '.*'] = ['string', Rule::in($field['options'] ?? [])];
                    break;
                case 'select':
                case 'radio':
                    $rules[$key] = array_filter([
                        $required ? 'required' : 'nullable',
                        'string',
                        Rule::in($field['options'] ?? []),
                    ]);
                    break;
                case 'yes_no':
                    $rules[$key] = array_filter([
                        $required ? 'required' : 'nullable',
                        'string',
                        Rule::in(['Yes', 'No']),
                    ]);
                    break;
                default:
                    $rules[$key] = ($required ? 'required' : 'nullable') . '|string|max:10000';
                    break;
            }
        }

        $validated = $request->validate($rules);
        $answers = $validated['answers'] ?? [];

        foreach ($fields as $field) {
            if ($field['field_type'] !== 'file' || !$request->hasFile('answers.' . $field['id'])) {
                continue;
            }

            $file = $request->file('answers.' . $field['id']);
            $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('brief-forms/uploads/' . $formRequest->id, $filename, 'local');
            $answers[$field['id']] = [
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
            ];
        }

        $brand = optional($formRequest->order)->brand_details;
        $pdfData = [
            'formRequest' => $formRequest,
            'client' => $client,
            'order' => $formRequest->order,
            'brand' => $brand,
            'fields' => $fields,
            'answers' => $answers,
            'logoDataUri' => $this->brandLogoDataUri($brand ? $brand->logo : null),
        ];

        try {
            $pdfBytes = PDF::loadView('briefs.pdf', $pdfData)->setPaper('a4')->output();
        } catch (\Throwable $exception) {
            report($exception);
            return redirect()->back()->withInput()->with('error', 'Your answers are saved in this page, but the PDF could not be generated. Please try submitting again.');
        }

        $pdfPath = 'brief-forms/submissions/brief-' . $formRequest->id . '.pdf';
        Storage::disk('local')->put($pdfPath, $pdfBytes);

        try {
            DB::transaction(function () use ($formRequest, $answers, $pdfPath) {
                BriefFormSubmission::create([
                    'brief_form_request_id' => $formRequest->id,
                    'answers' => $answers,
                    'pdf_path' => $pdfPath,
                    'submitted_at' => now(),
                ]);

                $formRequest->status = 'submitted';
                $formRequest->submitted_at = now();
                $formRequest->save();
            });
        } catch (\Throwable $exception) {
            Storage::disk('local')->delete($pdfPath);
            report($exception);
            return redirect()->back()->withInput()->with('error', 'We could not save your brief. Please try again.');
        }

        $mailSent = false;
        try {
            $pm = $formRequest->supportPerson;
            $adminEmails = Adminiy::where('role_id', 1)
                ->where('is_active', 1)
                ->pluck('email')
                ->filter()
                ->unique()
                ->reject(function ($email) use ($pm) {
                    return $pm && strtolower($email) === strtolower($pm->email);
                })
                ->values()
                ->all();

            if (!$pm || !$pm->email) {
                throw new \RuntimeException('The assigned Project Manager has no email address.');
            }

            Mail::to($pm->email)
                ->cc($adminEmails)
                ->send(new BriefSubmissionReceived($pdfData, storage_path('app/' . $pdfPath)));
            $mailSent = true;
        } catch (\Throwable $exception) {
            report($exception);
        }

        return redirect()->route('client.brief.dashboard')->with(
            $mailSent ? 'success' : 'warning',
            $mailSent
                ? 'Your brief was submitted. The assigned Project Manager and admins have been notified.'
                : 'Your brief was submitted and saved. Email delivery to the Project Manager/admins failed.'
        );
    }

    public function showSubmission($id)
    {
        $submission = BriefFormSubmission::with(['formRequest.client', 'formRequest.order.brand_details'])
            ->findOrFail($id);
        $this->authorizeSubmission($submission);

        return view('admin.brief_forms.submission', compact('submission'));
    }

    public function downloadAttachment($submissionId, $fieldId)
    {
        $submission = BriefFormSubmission::with('formRequest')->findOrFail($submissionId);
        $this->authorizeSubmission($submission);

        $file = $submission->answers[$fieldId] ?? null;
        abort_unless(is_array($file) && !empty($file['file_path']), 404);
        abort_unless(Storage::disk('local')->exists($file['file_path']), 404);

        return Storage::disk('local')->download($file['file_path'], $file['file_name'] ?? 'brief-attachment');
    }

    private function authenticatedClient()
    {
        $client = Auth::guard('user')->user();
        if (!$client || (int) $client->role_id !== (int) client_role_id()) {
            return null;
        }

        return $client;
    }

    private function authorizeSubmission(BriefFormSubmission $submission)
    {
        $user = auth_staff();
        $formRequest = $submission->formRequest;

        if (Auth::guard('adminiy')->check() && $user->isSuperAdmin()) {
            return;
        }

        if (Auth::guard('user')->check() && (int) $formRequest->support_person_id === (int) $user->id
            && $user->has_permission('view_brief_submissions')) {
            return;
        }

        if (Auth::guard('adminiy')->check() && $user->has_permission('view_brief_submissions')) {
            return;
        }

        abort(403);
    }

    private function brandLogoDataUri($logoPath)
    {
        if (!$logoPath) {
            return null;
        }

        $fullPath = public_path($logoPath);
        if (!is_file($fullPath)) {
            return null;
        }

        $mime = mime_content_type($fullPath);
        if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif'], true)) {
            return null;
        }

        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($fullPath));
    }
}
