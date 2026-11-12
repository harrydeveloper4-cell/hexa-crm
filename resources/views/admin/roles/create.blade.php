@extends('admin.layout.master')
@section('title', 'Create Role')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Create Role') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">{{ __('Roles') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Role Create</h6>
                    <a class="btn btn-info float-right" href="{{ route('roles.index') }}">Back</a>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-xl-6">
                                    <label>Role Name</label>
                                    <input class="form-control rounded" type="text" name="role"
                                        value="{{ old('role') }}" placeholder="e.g. Support Agent">
                                    @error('role')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
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
