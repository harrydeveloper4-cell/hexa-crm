@extends('admin.layout.master')
@section('title', 'Packages')

@section('breadcrumb-title')
    <h3>{{ __('Packages') }} ({{ ucfirst($brand->name) }})</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('admin.brands.index') }}">{{ __('Brands') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Packages') }}</li>
@endsection

@section('content')
    @php
        $selected = array_map('strval', $brand->packages ?? []);
    @endphp
    <div class="row">
        <div class="col-12 mt-4">
            <a class="btn btn-info float-right" href="{{ route('admin.brands.index') }}">Back</a>
        </div>
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Assign Packages</h6>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('packages.update.all') }}" method="POST" id="package-form">
                            @csrf
                            <input type="hidden" name="brand" value="{{ $brand->id }}">

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="packages">Packages</label>
                                    <select class="form-control select2" name="packages[]" id="packages" multiple>
                                        @foreach ($packages as $package)
                                            <option value="{{ $package->id }}"
                                                {{ in_array((string) $package->id, $selected) ? 'selected' : '' }}>
                                                {{ $package->package_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <input type="submit" value="Save" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Assigned Packages</h6>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            @forelse ($brand_packages as $package)
                                <div class="col-md-3 mb-3">
                                    @if ($package->img)
                                        <img src="{{ asset($package->img) }}" class="img img-thumbnail w-100">
                                    @endif
                                    <p class="mt-2 mb-0">{{ $package->package_name }}</p>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted mb-0">No packages assigned to this brand.</p>
                                </div>
                            @endforelse
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
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@endsection
