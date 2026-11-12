@extends('admin.layout.master')
@section('title', 'Roles')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Roles & Permissions') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Roles') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header justify-content-between align-items-center">
                    <h4 class="card-title">Roles</h4>
                    @if (auth_staff()->has_permission('assign_role_permission'))
                        <a class="btn btn-info float-right" href="{{ route('roles.create') }}"><i
                                class="icon-plus"></i> Create Role</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display table dataTable table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th>Role</th>
                                    <th>Permissions</th>
                                    <th>Users</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->role }}</td>
                                        <td>
                                            @if ($role->id == 1)
                                                <span class="badge badge-success">All Permissions</span>
                                            @else
                                                {{ $permissionCounts[$role->id] ?? 0 }} assigned
                                            @endif
                                        </td>
                                        <td>{{ $role->adminiy()->count() }}</td>
                                        <td>
                                            @if (auth_staff()->has_permission('assign_role_permission'))
                                                <a href="{{ route('roles.edit', ['id' => $role->id]) }}"
                                                    title="Assign Permissions">
                                                    <i class="icon-pencil"></i>
                                                </a>
                                                @if ($role->id != 1)
                                                    <a class="delete_confirmation"
                                                        href="{{ route('roles.destroy', ['id' => $role->id]) }}"
                                                        title="Delete">
                                                        <i class="icon-trash"></i>
                                                    </a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID#</th>
                                    <th>Role</th>
                                    <th>Permissions</th>
                                    <th>Users</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.delete_confirmation', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                if (confirm('Are you sure you want to delete this Role?')) {
                    window.location.href = url;
                }
            });
        });
    </script>
@endsection
