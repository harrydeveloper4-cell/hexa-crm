@extends('admin.layout.master')
@section('title', 'Change Password')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Change Password') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><i class="icon-home mr-1"></i></li>
    <li class="breadcrumb-item active">{{ __('Change Password') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <a class = "btn btn-info float-right" href = "{{ route('admin.update_password') }}">Back</a>
        </div>
        <div class="col-12 mt-4">
            <div class="card">
                {{-- <div class="card-header">
                    <h6 class="card-title">Brand Edit</h6>
                </div> --}}
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form action = "{{ route('admin.update_password') }}" method = "POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="current_password">Current Password</label>
                                            <input type="password" class="form-control rounded @error('current_password') is-invalid @enderror" name = "current_password"
                                                id="current_password" placeholder="Current Password">
                                            @error('current_password')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="password">New Password</label>
                                            <input type="password" class="form-control rounded @error('password') is-invalid @enderror" name = "password"
                                                id="password" placeholder="New Password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="password_confirmation">Confirm Password</label>
                                            <input type="password" class="form-control rounded @error('password_confirmation') is-invalid @enderror" name = "password_confirmation"
                                                id="password_confirmation" placeholder="confirm Password">
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <input type="submit" value = "Save" class = "btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#package-form').validate({
                rules: {
                    name: 'required',
                    description: 'required',
                    logo: {
                        extension: "jpg|jpeg|png|bmp"
                    },
                    link: 'required',
                }
            })
        })
    </script>
@endsection
