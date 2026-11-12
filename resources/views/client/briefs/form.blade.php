@extends('client.briefs.layout')
@section('title', $formRequest->form_title)

@section('top-action')
    <a href="{{ route('client.brief.dashboard') }}" class="btn btn-sm btn-outline-secondary">My briefs</a>
@endsection

@section('content')
    <main class="brief-wrap">
        <div class="brief-heading">
            @if ($brand && $brand->logo)
                <img class="brief-brand mb-3" src="{{ asset($brand->logo) }}" alt="{{ $brand->name }} logo">
            @endif
            <div class="text-uppercase" style="font-size:11px;letter-spacing:1px;color:var(--brief-purple);font-weight:700;">
                {{ $brand->name ?? 'Project brief' }}
            </div>
            <h1>{{ $formRequest->form_title }}</h1>
            @if ($formRequest->form->description ?? false)
                <p>{{ $formRequest->form->description }}</p>
            @else
                <p>Please complete the questions below. Your answers will be shared with your assigned project team.</p>
            @endif
            <small class="brief-help">Order #{{ $formRequest->order->order_number ?: $formRequest->order_id }}</small>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">Please check the highlighted fields and submit again.</div>
        @endif

        <form method="POST" action="{{ route('client.brief.submit', $formRequest->id) }}" enctype="multipart/form-data">
            @csrf
            @foreach ($fields as $index => $field)
                @php
                    $fieldKey = 'answers.' . $field['id'];
                    $options = $field['options'] ?? [];
                    $required = !empty($field['is_required']);
                    $oldValue = old($fieldKey);
                @endphp
                <section class="brief-card">
                    <h2><span class="badge badge-primary mr-2">{{ $index + 1 }}</span>{{ $field['label'] }}@if ($required)<span class="required">*</span>@endif</h2>
                    @if (!empty($field['help_text']))
                        <p class="brief-help">{{ $field['help_text'] }}</p>
                    @endif

                    @switch($field['field_type'])
                        @case('textarea')
                            <textarea class="form-control brief-input @error($fieldKey) is-invalid @enderror"
                                name="answers[{{ $field['id'] }}]" {{ $required ? 'required' : '' }}>{{ $oldValue }}</textarea>
                            @break
                        @case('select')
                            <select class="form-control brief-input @error($fieldKey) is-invalid @enderror"
                                name="answers[{{ $field['id'] }}]" {{ $required ? 'required' : '' }}>
                                <option value="">Select an option</option>
                                @foreach ($options as $option)
                                    <option value="{{ $option }}" {{ (string) $oldValue === (string) $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                            @break
                        @case('radio')
                        @case('yes_no')
                            @php($radioOptions = $field['field_type'] === 'yes_no' ? ['Yes', 'No'] : $options)
                            <div>
                                @foreach ($radioOptions as $option)
                                    <label class="brief-option">
                                        <input type="radio" name="answers[{{ $field['id'] }}]" value="{{ $option }}"
                                            {{ (string) $oldValue === (string) $option ? 'checked' : '' }}
                                            {{ $required && $loop->first ? 'required' : '' }}>
                                        {{ $option }}
                                    </label>
                                @endforeach
                            </div>
                            @break
                        @case('checkbox')
                            <div>
                                @foreach ($options as $option)
                                    <label class="brief-option">
                                        <input type="checkbox" name="answers[{{ $field['id'] }}][]"
                                            value="{{ $option }}"
                                            {{ is_array($oldValue) && in_array($option, $oldValue) ? 'checked' : '' }}>
                                        {{ $option }}
                                    </label>
                                @endforeach
                            </div>
                            @break
                        @case('file')
                            <input class="form-control-file @error($fieldKey) is-invalid @enderror"
                                type="file" name="answers[{{ $field['id'] }}]"
                                accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt"
                                {{ $required ? 'required' : '' }}>
                            <small class="brief-help">Upload a JPG, PNG, PDF, Office document, or text file (max 10 MB).</small>
                            @break
                        @default
                            <input class="form-control brief-input @error($fieldKey) is-invalid @enderror"
                                type="text" name="answers[{{ $field['id'] }}]" value="{{ $oldValue }}"
                                {{ $required ? 'required' : '' }}>
                    @endswitch
                    @error($fieldKey)
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </section>
            @endforeach
            <div class="brief-footer">
                <button class="btn btn-outline-secondary mr-2" type="button" onclick="window.location='{{ route('client.brief.dashboard') }}'">Back to dashboard</button>
                <button class="btn brief-btn" type="submit">Submit form</button>
            </div>
        </form>
    </main>
@endsection
