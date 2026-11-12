@extends('admin.layout.master')
@section('title', 'Packages')

@section('breadcrumb-title')
    <h3>{{ __('Edit') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('packages') }}">{{ __('Packages') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Edit') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Package Edit</h6>
                    <a class="btn btn-info btn-xs float-right" href="{{ route('packages') }}">Back</a>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form action="{{ route('packages.update', ['id' => $package->id]) }}" method="POST"
                                    id="package-form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="package_name">Package Name</label>
                                            <input type="text" class="form-control rounded" name="package_name"
                                                id="package_name" placeholder="Package Name"
                                                value="{{ old('package_name', $package->package_name) }}">
                                            @error('package_name')
                                                <span class="text-danger"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="img">Image</label>
                                            <input type="file" class="form-control rounded" name="img" id="img">
                                            @error('img')
                                                <span class="text-danger"><strong>{{ $message }}</strong></span>
                                            @enderror
                                            @if ($package->img)
                                                <img src="{{ asset($package->img) }}" class="mt-2 w-25">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="status">Status</label><br>
                                            <input type="checkbox" name="status" value="1" data-toggle="toggle"
                                                data-on="Active" data-off="Inactive"
                                                {{ $package->status == 'active' ? 'checked' : '' }}>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <input type="submit" value="Save" class="btn btn-primary">
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
                    package_name: 'required',
                    img: {
                        extension: "jpg|jpeg|png|bmp"
                    }
                }
            });
        });
    </script>
@endsection
