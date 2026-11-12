@extends('admin.layout.master')
@section('title', 'Packages')

@section('breadcrumb-title')
    <h3>{{ __('Packages') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Packages') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">
                    <h4 class="card-title">Packages</h4>
                    @if ($authUser->has_permission('packages_create'))
                        <a class="btn btn-info btn-xs float-right" href="{{ route('packages.create') }}"><i
                                class="icon-plus"></i> Create</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display table dataTable table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    @if ($authUser->has_permission('packages_edit'))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($packages as $package)
                                    <tr>
                                        <td>{{ $package->id }}</td>
                                        <td>{{ $package->package_name }}</td>
                                        <td>
                                            @if ($package->img)
                                                <img src="{{ asset($package->img) }}" class="img img-thumbnail"
                                                    width="100px" height="100px">
                                            @endif
                                        </td>
                                        <td>
                                            @if ($package->status == 'active')
                                                <span class="badge badge-primary">Active</span>
                                            @else
                                                <span class="badge badge-warning">Inactive</span>
                                            @endif
                                        </td>
                                        @if ($authUser->has_permission('packages_edit'))
                                            <td>
                                                <a href="{{ route('packages.edit', ['id' => $package->id]) }}"><i
                                                        class="icon-pencil"></i></a>
                                                <a class="delete_confirmation"
                                                    href="{{ route('packages.destroy', ['id' => $package->id]) }}"><i
                                                        class="icon-trash"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
