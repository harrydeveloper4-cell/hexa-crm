@extends('admin.layout.master')
@section('title', 'Brands')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Brand Edit') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><i class="icon-home mr-1"></i></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.brands.index') }}">{{ __('Brands') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Edit') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <a class = "btn btn-info float-right" href = "{{ route('admin.brands.index') }}">Back</a>
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
                                <form action = "{{ route('admin.brands.update', ['id' => $brand->id]) }}" method = "POST"
                                    id = "package-form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control rounded" name = "name"
                                                id="name" placeholder="Name" value = "{{ $brand->name ?? '' }}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="phonenumber">Contact Number</label>
                                            <input type="text" class="form-control rounded" name = "phonenumber"
                                                id="phonenumber" placeholder="Contact Number" value = "{{ $brand->phonenumber ?? '' }}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="email_address">Email Address</label>
                                            <input type="email" class="form-control rounded" name = "email_address"
                                                id="email_address" placeholder="Email Address" value = "{{ $brand->email_address ?? '' }}">
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="description">Description</label>
                                            <textarea class = "form-control" name = "description" id="description">{{ $brand->desc ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    {{--
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail4">Content Details</label>
                                            <textarea class="summernote" name = "details"  id="details"  value = "" ></textarea>
                                        </div>
                                    </div>
                                    --}}
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="currencies">Brand Currency</label>
                                            @php
                                                $brand_currency = json_decode($brand->currency);
                                            @endphp
                                            <select class="form-control select" name = "currencies[]" id="currencies"
                                                multiple>
                                                <option value = "">Select Currency</option>
                                                @foreach ($currencies as $currency)
                                                    <option value = "{{ $currency->code }}"
                                                        {{ in_array($currency->code, $brand_currency) ? 'selected' : '' }}>
                                                        {{ $currency->country . ' (' . $currency->code . ')' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="url">Link</label>
                                            <input type="url" class="form-control rounded" name = "link"
                                                id="url" placeholder="Link" value = "{{ $brand->link ?? '' }}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="logo">Logo</label>
                                            <input type="file" class="form-control rounded" name = "logo" id="logo"
                                                value = "">
                                            @if ($brand->logo != null)
                                                <img src = "{{ asset($brand->logo) }}" class = "w-50">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        @php
                                            $brand_packages = array_map('strval', $brand->packages ?? []);
                                            $brand_merchants = array_map('strval', $brand->merchant ?? []);
                                        @endphp
                                        <div class="form-group col-md-6">
                                            <label for="packages">Packages</label>
                                            <select class="form-control select2" name="packages[]" id="packages"
                                                multiple>
                                                @foreach ($packages as $package)
                                                    <option value="{{ $package->id }}"
                                                        {{ in_array((string) $package->id, $brand_packages) ? 'selected' : '' }}>
                                                        {{ $package->package_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="merchants">Merchants</label>
                                            <select class="form-control select2" name="merchants[]" id="merchants"
                                                multiple>
                                                @foreach ($merchants as $merchant)
                                                    <option value="{{ $merchant->id }}"
                                                        {{ in_array((string) $merchant->id, $brand_merchants) ? 'selected' : '' }}>
                                                        {{ $merchant->merchant }}
                                                    </option>
                                                @endforeach
                                            </select>
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
