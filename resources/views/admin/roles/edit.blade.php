@extends('admin.layout.master')
@section('title', 'Assign Permissions')

@section('css')
<style>
    .permission-box {
        border: 1px solid #e3e3e3;
        border-radius: 6px;
        padding: 10px 12px;
        margin-bottom: 10px;
    }
</style>
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Assign Permissions') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">{{ __('Roles') }}</a></li>
    <li class="breadcrumb-item active">{{ $role->role }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Role: {{ $role->role }}</h6>
                    <a class="btn btn-info float-right" href="{{ route('roles.index') }}">Back</a>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if ($role->id == 1)
                            <div class="alert alert-success">
                                Super Admin always has every permission. Permission assignment is not required for this
                                role.
                            </div>
                        @endif

                        <form action="{{ route('roles.update', ['id' => $role->id]) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-xl-6">
                                    <label>Role Name</label>
                                    <input class="form-control rounded" type="text" name="role"
                                        value="{{ $role->role }}" {{ $role->id == 1 ? 'readonly' : '' }}>
                                    @error('role')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="mb-0">Permissions</label>
                                <div>
                                    <input type="checkbox" id="check-all"> <small>Select All</small>
                                </div>
                            </div>

                            <div class="row">
                                @foreach ($permissions as $permission)
                                    <div class="col-md-4 col-lg-4 col-xl-4">
                                        <div class="permission-box">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input permission-checkbox"
                                                    id="permission-{{ $permission->id }}" name="permissions_id[]"
                                                    value="{{ $permission->id }}"
                                                    {{ in_array($permission->id, $assigned) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="permission-{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                    <a class="btn btn-secondary" href="{{ route('roles.index') }}">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#check-all').on('change', function() {
                $('.permission-checkbox').prop('checked', $(this).prop('checked'));
            });

            $(document).on('change', '.permission-checkbox', function() {
                if (!$(this).prop('checked')) {
                    $('#check-all').prop('checked', false);
                }
            });
        });
    </script>
@endsection
