@extends('admin.layout.master')
@section('title', 'Merchants')

@section('breadcrumb-title')
    <h3>{{ __('Merchants') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Merchants') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header justify-content-between align-items-center">
                    <h4 class="card-title">Merchants</h4>
                    @if ($authUser->has_permission('merchant_create'))
                        <a class="btn btn-info float-right" href="{{ route('merchant.create') }}"><i
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
                                    <th>Config Keys</th>
                                    <th>Status</th>
                                    @if ($authUser->has_permission('merchant_edit'))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($merchants as $merchant)
                                    <tr>
                                        <td>{{ $merchant->id }}</td>
                                        <td>{{ $merchant->merchant }}</td>
                                        <td>
                                            @foreach (($merchant->config_keys ?? []) as $key => $value)
                                                <span class="badge badge-light">{{ $key }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($merchant->status == 'active')
                                                <span class="badge badge-primary">Active</span>
                                            @else
                                                <span class="badge badge-warning">Inactive</span>
                                            @endif
                                        </td>
                                        @if ($authUser->has_permission('merchant_edit'))
                                            <td>
                                                <a href="{{ route('merchant.edit', ['id' => $merchant->id]) }}"><i
                                                        class="icon-pencil"></i></a>
                                                <a class="delete_confirmation"
                                                    href="{{ route('merchant.destroy', ['id' => $merchant->id]) }}"><i
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
