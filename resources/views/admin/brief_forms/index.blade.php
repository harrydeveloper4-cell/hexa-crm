@extends('admin.layout.master')
@section('title', 'Brief Form Templates')

@section('breadcrumb-title')
    <h3>{{ __('Brief Form Templates') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('admin.assigned_clients') }}">Support</a></li>
    <li class="breadcrumb-item active">Brief Form Templates</li>
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
                <div class="card-header">
                    <h4 class="card-title mb-0">Create a brief form</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.brief_forms.store') }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Form title *</label>
                                <input class="form-control" name="title" value="{{ old('title') }}" required maxlength="255">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Description</label>
                                <input class="form-control" name="description" value="{{ old('description') }}" maxlength="2000">
                            </div>
                            <div class="form-group col-md-2 d-flex align-items-end">
                                <button class="btn btn-primary mb-3" type="submit">Create form</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">Form templates</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Form</th>
                                    <th>Active fields</th>
                                    <th>Status</th>
                                    <th>Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($forms as $form)
                                    <tr>
                                        <td>
                                            <strong>{{ $form->title }}</strong>
                                            @if ($form->description)
                                                <small class="d-block text-muted">{{ $form->description }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $form->active_fields_count }}</td>
                                        <td>
                                            <span class="badge {{ $form->is_active ? 'badge-success' : 'badge-secondary' }}">
                                                {{ $form->is_active ? 'Active' : 'Archived' }}
                                            </span>
                                        </td>
                                        <td>{{ optional($form->updated_at)->format('M d, Y') }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-info" href="{{ route('admin.brief_forms.edit', $form->id) }}">Manage fields</a>
                                            @if ($form->is_active)
                                                <form method="POST" action="{{ route('admin.brief_forms.archive', $form->id) }}"
                                                    class="d-inline" onsubmit="return confirm('Archive this form? Existing requests and submissions will remain available.');">
                                                    @csrf
                                                    <button class="btn btn-sm btn-secondary" type="submit">Archive</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center">No brief forms created yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
