<?php

namespace App\Http\Controllers;

use App\Mail\BriefFormLinks;
use App\Models\Adminiy;
use App\Models\BriefForm;
use App\Models\BriefFormField;
use App\Models\BriefFormRequest;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BriefFormController extends Controller
{
    private $fieldTypes = ['text', 'textarea', 'select', 'radio', 'checkbox', 'yes_no', 'file'];

    public function index()
    {
        $forms = BriefForm::withCount(['fields as active_fields_count' => function ($query) {
            $query->where('is_active', true);
        }])->orderBy('id')->get();

        return view('admin.brief_forms.index', compact('forms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
        ]);

        BriefForm::create($data + ['is_active' => true]);

        return redirect()->route('admin.brief_forms.index')->with('success', 'Brief form created.');
    }

    public function edit($id)
    {
        $form = BriefForm::with(['fields' => function ($query) {
            $query->orderBy('sort_order')->orderBy('id');
        }])->findOrFail($id);

        return view('admin.brief_forms.edit', compact('form'));
    }

    public function update(Request $request, $id)
    {
        $form = BriefForm::findOrFail($id);
        $form->update($request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
        ]));

        return redirect()->back()->with('success', 'Brief form updated.');
    }

    public function archive($id)
    {
        $form = BriefForm::findOrFail($id);
        $form->is_active = false;
        $form->save();

        return redirect()->route('admin.brief_forms.index')
            ->with('success', 'Brief form archived. Previous links and submissions are preserved.');
    }

    public function storeField(Request $request, $formId)
    {
        $form = BriefForm::findOrFail($formId);
        $data = $this->validatedField($request);
        $data['brief_form_id'] = $form->id;
        $data['options'] = $this->fieldOptions($request, $data['field_type']);
        $data['sort_order'] = $data['sort_order'] ?? ((int) $form->fields()->max('sort_order') + 1);
        $data['is_active'] = true;

        BriefFormField::create($data);

        return redirect()->back()->with('success', 'Field added.');
    }

    public function updateField(Request $request, $formId, $fieldId)
    {
        $field = BriefFormField::where('brief_form_id', $formId)->findOrFail($fieldId);
        $data = $this->validatedField($request);
        $data['options'] = $this->fieldOptions($request, $data['field_type']);
        $field->update($data);

        return redirect()->back()->with('success', 'Field updated.');
    }

    public function removeField($formId, $fieldId)
    {
        $field = BriefFormField::where('brief_form_id', $formId)->findOrFail($fieldId);
        $field->is_active = false;
        $field->save();

        return redirect()->back()->with('success', 'Field removed from future form links.');
    }

    public function sendToClient(Request $request, $clientId)
    {
        $data = $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'form_ids' => 'required|array|min:1',
            'form_ids.*' => 'required|integer|distinct|exists:brief_forms,id',
        ]);

        $client = User::findOrFail($clientId);
        $order = Order::where('id', $data['order_id'])
            ->where(function ($query) use ($client) {
                $query->where('user_id', $client->id)
                    ->orWhere('customer_email', $client->email);
            })
            ->firstOrFail();

        if (!$this->canSendForClient($client, $order)) {
            abort(403, 'You cannot send a brief form to this client.');
        }

        $forms = BriefForm::with('activeFields')
            ->where('is_active', true)
            ->whereIn('id', $data['form_ids'])
            ->get();

        if ($forms->count() !== count($data['form_ids'])) {
            return redirect()->back()->with('error', 'One or more selected forms are unavailable.');
        }

        if ($forms->contains(function ($form) {
            return $form->activeFields->isEmpty();
        })) {
            return redirect()->back()->with('error', 'Every selected form must have at least one active field.');
        }

        $assignedOrder = Order::whereNull('previous_order_id')
            ->whereNotNull('support_person_id')
            ->where(function ($query) use ($client) {
                $query->where('user_id', $client->id)
                    ->orWhere('customer_email', $client->email);
            })
            ->orderByDesc('id')
            ->first();

        if (!$assignedOrder) {
            return redirect()->back()->with('error', 'This client has no assigned Project Manager.');
        }

        $formLinks = [];
        $formRequests = [];
        $expiresAt = Carbon::now()->addDays(30);

        foreach ($forms as $form) {
            $rawToken = bin2hex(random_bytes(32));
            $formRequest = BriefFormRequest::create([
                'brief_form_id' => $form->id,
                'order_id' => $order->id,
                'client_id' => $client->id,
                'support_person_id' => $assignedOrder->support_person_id,
                'form_title' => $form->title,
                'fields_snapshot' => $form->activeFields->map(function ($field) {
                    return [
                        'id' => $field->id,
                        'label' => $field->label,
                        'field_type' => $field->field_type,
                        'help_text' => $field->help_text,
                        'options' => $field->options ?: [],
                        'is_required' => (bool) $field->is_required,
                        'sort_order' => (int) $field->sort_order,
                    ];
                })->values()->all(),
                'access_token_hash' => hash('sha256', $rawToken),
                'status' => 'sent',
                'email_status' => 'pending',
                'expires_at' => $expiresAt,
            ]);

            $formRequests[] = $formRequest;
            $formLinks[] = [
                'title' => $formRequest->form_title,
                'url' => route('brief.access', ['token' => $rawToken]),
                'expires_at' => $expiresAt,
            ];
        }

        try {
            Mail::to($client->email)->send(new BriefFormLinks([
                'client_name' => trim($client->firstname . ' ' . $client->lastname),
                'forms' => $formLinks,
            ]));

            foreach ($formRequests as $formRequest) {
                $formRequest->email_status = 'sent';
                $formRequest->sent_at = now();
                $formRequest->save();
            }

            return redirect()->back()->with('success', 'Selected brief form links emailed to the client.');
        } catch (\Throwable $exception) {
            report($exception);

            foreach ($formRequests as $formRequest) {
                $formRequest->email_status = 'failed';
                $formRequest->save();
            }

            return redirect()->back()->with('error', 'Brief links were prepared, but the email could not be sent. Please check mail configuration and send again.');
        }
    }

    public function submissions()
    {
        $user = auth_staff();
        $query = BriefFormRequest::with(['client', 'order.brand_details', 'submission'])
            ->whereHas('submission')
            ->orderByDesc('submitted_at');

        if (!Auth::guard('adminiy')->check() || !$user->isSuperAdmin()) {
            $query->where('support_person_id', $user->id);
        }

        $submissions = $query->get();

        return view('admin.brief_forms.submissions', compact('submissions'));
    }

    public function downloadPdf($submissionId)
    {
        $submission = \App\Models\BriefFormSubmission::with('formRequest')->findOrFail($submissionId);
        $request = $submission->formRequest;
        $user = auth_staff();

        if ((!Auth::guard('adminiy')->check() || !$user->isSuperAdmin())
            && (int) $request->support_person_id !== (int) $user->id) {
            abort(403);
        }

        if (!$submission->pdf_path || !\Storage::disk('local')->exists($submission->pdf_path)) {
            abort(404, 'Submission PDF not found.');
        }

        return \Storage::disk('local')->download(
            $submission->pdf_path,
            Str::slug($request->form_title) . '-submission-' . $submission->id . '.pdf'
        );
    }

    private function validatedField(Request $request)
    {
        return $request->validate([
            'label' => 'required|string|max:255',
            'field_type' => 'required|in:' . implode(',', $this->fieldTypes),
            'help_text' => 'nullable|string|max:1000',
            'options_text' => 'nullable|string|max:5000',
            'is_required' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0|max:10000',
        ]) + ['is_required' => $request->boolean('is_required')];
    }

    private function fieldOptions(Request $request, $type)
    {
        if (!in_array($type, ['select', 'radio', 'checkbox'], true)) {
            return null;
        }

        return collect(preg_split('/\r\n|\r|\n/', (string) $request->input('options_text')))
            ->map(function ($option) {
                return trim($option);
            })
            ->filter()
            ->values()
            ->all();
    }

    private function canSendForClient(User $client, Order $order)
    {
        $staff = auth_staff();
        if (Auth::guard('adminiy')->check()) {
            return $staff->isSuperAdmin() || $staff->has_permission('send_brief_forms');
        }

        if ((int) $staff->role_id !== support_role_id()) {
            return false;
        }

        return Order::where('support_person_id', $staff->id)
            ->whereNull('previous_order_id')
            ->where(function ($query) use ($client) {
                $query->where('user_id', $client->id)
                    ->orWhere('customer_email', $client->email);
            })
            ->exists();
    }
}
