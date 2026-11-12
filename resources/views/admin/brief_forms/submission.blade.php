@extends('admin.layout.master')
@section('title', 'Brief Submission')

@section('breadcrumb-title')
    <h3>{{ __('Brief Submission') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('admin.brief_forms.submissions') }}">Brief Submissions</a></li>
    <li class="breadcrumb-item active">#{{ $submission->id }}</li>
@endsection

@section('content')
    @php
        $formRequest = $submission->formRequest;
        $fields = $formRequest->fields_snapshot ?: [];
        $answers = $submission->answers ?: [];
    @endphp
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{ $formRequest->form_title }}</h4>
                    <div>
                        @if ($submission->pdf_path)
                            <a class="btn btn-sm btn-primary" href="{{ route('admin.brief_forms.pdf', $submission->id) }}">
                                Download PDF
                            </a>
                        @endif
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.brief_forms.submissions') }}">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Client:</strong>
                                {{ trim(($formRequest->client->firstname ?? '') . ' ' . ($formRequest->client->lastname ?? '')) ?: '--' }}
                                <small class="text-muted">({{ $formRequest->client->email ?? '--' }})</small>
                            </p>
                            <p class="mb-1"><strong>Order:</strong>
                                #{{ optional($formRequest->order)->order_number ?: $formRequest->order_id }}
                                @if (optional($formRequest->order)->brand_details)
                                    - {{ $formRequest->order->brand_details->name }}
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Project Manager:</strong>
                                {{ trim(($formRequest->supportPerson->firstname ?? '') . ' ' . ($formRequest->supportPerson->lastname ?? '')) ?: '--' }}
                            </p>
                            <p class="mb-1"><strong>Submitted:</strong>
                                {{ optional($submission->submitted_at)->format('M d, Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">Answers</h4>
                </div>
                <div class="card-body">
                    @forelse ($fields as $field)
                        @php
                            $answer = $answers[$field['id']] ?? null;
                            $isFile = is_array($answer) && array_key_exists('file_path', $answer);
                        @endphp
                        <div class="border rounded p-3 mb-3">
                            <div class="text-muted text-uppercase" style="font-size:11px;letter-spacing:.5px;">
                                {{ $field['label'] }}
                            </div>
                            <div class="mt-2">
                                @if ($isFile)
                                    <a href="{{ route('admin.brief_forms.attachment', [$submission->id, $field['id']]) }}">
                                        <i class="icon-paper-clip"></i> {{ $answer['file_name'] ?? 'Download attachment' }}
                                    </a>
                                @elseif (is_array($answer))
                                    {{ implode(', ', $answer) ?: 'No answer provided' }}
                                @elseif ($answer !== null && $answer !== '')
                                    {{ $answer }}
                                @else
                                    <span class="text-muted font-italic">No answer provided</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info mb-0">This submission has no recorded questions.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
