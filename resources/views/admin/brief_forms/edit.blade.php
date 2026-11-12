@extends('admin.layout.master')
@section('title', 'Manage Brief Form')

@section('breadcrumb-title')
    <h3>{{ __('Manage Brief Form') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('admin.brief_forms.index') }}">Brief Form Templates</a></li>
    <li class="breadcrumb-item active">{{ $form->title }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <div class="card">
                <div class="card-header"><h4 class="card-title mb-0">Form details</h4></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.brief_forms.update', $form->id) }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Form title *</label>
                                <input class="form-control" name="title" value="{{ $form->title }}" required maxlength="255">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Description</label>
                                <input class="form-control" name="description" value="{{ $form->description }}" maxlength="2000">
                            </div>
                            <div class="form-group col-md-2 d-flex align-items-end">
                                <button class="btn btn-primary mb-3" type="submit">Save form</button>
                            </div>
                        </div>
                    </form>
                    <p class="text-muted mb-0">Sent form links keep a snapshot of their original questions. Template edits affect new links only.</p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header"><h4 class="card-title mb-0">Questions / fields</h4></div>
                <div class="card-body">
                    @forelse ($form->fields->where('is_active', true) as $field)
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>{{ $field->label }}</strong>
                                <span class="badge badge-light">{{ str_replace('_', ' ', ucfirst($field->field_type)) }}</span>
                            </div>
                            <details>
                                <summary class="text-primary" style="cursor:pointer;">Edit this field</summary>
                                <form method="POST" action="{{ route('admin.brief_forms.fields.update', [$form->id, $field->id]) }}"
                                    class="mt-3">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Question / label *</label>
                                            <input class="form-control" name="label" value="{{ $field->label }}" required maxlength="255">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Field type *</label>
                                            <select class="form-control field-type" name="field_type" required>
                                                @foreach (['text', 'textarea', 'select', 'radio', 'checkbox', 'yes_no', 'file'] as $type)
                                                    <option value="{{ $type }}" {{ $field->field_type === $type ? 'selected' : '' }}>
                                                        {{ str_replace('_', ' ', ucfirst($type)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Order</label>
                                            <input class="form-control" type="number" min="0" name="sort_order" value="{{ $field->sort_order }}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="d-block">Required</label>
                                            <div class="custom-control custom-checkbox mt-2">
                                                <input class="custom-control-input" type="checkbox" id="required_{{ $field->id }}"
                                                    name="is_required" value="1" {{ $field->is_required ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="required_{{ $field->id }}">Client must answer</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Help text (optional)</label>
                                            <input class="form-control" name="help_text" value="{{ $field->help_text }}" maxlength="1000">
                                        </div>
                                        <div class="form-group col-md-6 options-field">
                                            <label>Choices (one per line)</label>
                                            <textarea class="form-control" name="options_text" rows="3">{{ implode("\n", $field->options ?: []) }}</textarea>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-primary" type="submit">Save field</button>
                                </form>
                                <form method="POST" action="{{ route('admin.brief_forms.fields.remove', [$form->id, $field->id]) }}"
                                    class="mt-2" onsubmit="return confirm('Remove this field from future links? Existing submissions will be preserved.');">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Remove field</button>
                                </form>
                            </details>
                            @if ($field->help_text)
                                <small class="d-block text-muted mt-2">{{ $field->help_text }}</small>
                            @endif
                        </div>
                    @empty
                        <div class="alert alert-info">No active questions. Add fields before sending this form.</div>
                    @endforelse
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header"><h4 class="card-title mb-0">Add a question</h4></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.brief_forms.fields.store', $form->id) }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Question / label *</label>
                                <input class="form-control" name="label" required maxlength="255">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Field type *</label>
                                <select class="form-control field-type" name="field_type" required>
                                    <option value="text">Text</option>
                                    <option value="textarea">Long text</option>
                                    <option value="select">Select</option>
                                    <option value="radio">Radio</option>
                                    <option value="checkbox">Checkboxes</option>
                                    <option value="yes_no">Yes / No</option>
                                    <option value="file">File upload</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Order</label>
                                <input class="form-control" type="number" min="0" name="sort_order" value="0">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="d-block">Required</label>
                                <div class="custom-control custom-checkbox mt-2">
                                    <input class="custom-control-input" type="checkbox" id="new_required" name="is_required" value="1">
                                    <label class="custom-control-label" for="new_required">Client must answer</label>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Help text (optional)</label>
                                <input class="form-control" name="help_text" maxlength="1000">
                            </div>
                            <div class="form-group col-md-6 options-field">
                                <label>Choices (one per line)</label>
                                <textarea class="form-control" name="options_text" rows="3"
                                    placeholder="Option one&#10;Option two"></textarea>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Add field</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            function toggleChoices(select) {
                var show = ['select', 'radio', 'checkbox'].indexOf($(select).val()) !== -1;
                $(select).closest('form').find('.options-field').toggle(show);
            }
            $('.field-type').each(function() { toggleChoices(this); });
            $(document).on('change', '.field-type', function() { toggleChoices(this); });
        });
    </script>
@endsection
