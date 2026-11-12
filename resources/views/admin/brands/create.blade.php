@extends('admin.layout.master')
@section('title', 'Brands')

@section('css')
<style>
    #package-form .error{
        color: red;
    }

</style>
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Brand Create') }}</h3>
@endsection
{{-- @dd($currencies) --}}
@section('breadcrumb-items')
    <li class="breadcrumb-item"><i class="icon-home mr-1"></i></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.brands.index') }}">{{ __('Brands') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <a class = "btn btn-info float-right" href = "{{ route('admin.brands.index') }}">Back</a>
        </div>
        <div class="col-12 mt-4">
            <div class="card">
                {{-- <div class="card-header">
                    <h6 class="card-title">Brand Create</h6>
                </div> --}}
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form action = "{{ route('admin.brands.store') }}" method = "POST" id = "package-form"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputEmail4">Name</label>
                                            <input type="text" class="form-control rounded" name = "name"
                                                id="inputEmail4" placeholder="Name" value = "{{old('name')}}">
                                                
                                            @error('name')
                                                <span class="invalid-feedback error" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="phonenumber">Contact Number</label>
                                            <input type="text" class="form-control rounded" name = "phonenumber"
                                                id="phonenumber" placeholder="Contact Number" value = "{{old('phonenumber')}}">
                                                
                                            @error('phonenumber')
                                                <span class="invalid-feedback error" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="email_address">Email Address</label>
                                            <input type="email" class="form-control rounded" name = "email_address"
                                                id="email_address" placeholder="Email Address" value = "{{old('email_address')}}">
                                                
                                            @error('email_address')
                                                <span class="invalid-feedback error" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail4">Description</label>
                                            <textarea class = "form-control" name = "description" id="description">{{old('description')}}</textarea>
                                            @error('description')
                                                <span class="invalid-feedback error" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
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
                                            <label for="inputEmail4">Brand Currency</label>
                                            <select class="form-control select2" name = "currencies[]" id="inputEmail4"
                                                multiple>
                                                {{-- <option value = "" >Select Currency</option> --}}
                                                @foreach ($currencies as $currency)
                                                    <option value = "{{ $currency->code }}"
                                                        {{ is_array(old('currencies')) && in_array($currency->code, old('currencies')) ? 'selected' : '' }}   
                                                    >
                                                        {{ $currency->country . ' (' . $currency->code . ')' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('currencies')
                                                <span class="invalid-feedback error" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="link">Link</label>
                                            <input type="url" class="form-control rounded" name = "link"
                                                id="link" placeholder="Link" value ="{{old('link')}}">
                                            @error('link')
                                                <span class="invalid-feedback error" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                            <div class="form-group col-md-4">
                                                <label for="logo">Logo</label>
                                                <input type="file" class="form-control rounded " name = "logo" id="logo">
                                                @error('logo')
                                                    <span class="invalid-feedback error" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="packages">Packages</label>
                                            <select class="form-control select2" name="packages[]" id="packages"
                                                multiple>
                                                @foreach ($packages as $package)
                                                    <option value="{{ $package->id }}"
                                                        {{ is_array(old('packages')) && in_array((string) $package->id, array_map('strval', old('packages'))) ? 'selected' : '' }}>
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
                                                        {{ is_array(old('merchants')) && in_array((string) $merchant->id, array_map('strval', old('merchants'))) ? 'selected' : '' }}>
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
            // Initialize Select2 for multiple selects
            $('.select2').select2({
                theme: 'bootstrap4'  // AdminLTE's Bootstrap4 theme for Select2
            });
        });
        $(document).ready(function() {
            $('#package-form').validate({
                rules: {
                    name: 'required',
                    description: 'required',
                    currencies: 'required',
                    link: {
                        required: true,
                    },
                    logo: {
                        required: true,
                        extension: "jpg|jpeg|png|bmp"
                    },
                    // merchants: 'required'
                },
                errorPlacement : function(error, element){
                    if(element.is('select')){
                        error.appendTo(element.parents('.form-group'));
                    }
                    error.insertAfter(element);
                    if (!element.next('span.required').length) {
                        $('<span class="required text-danger">*</span>').insertBefore(element);
                    }
                },
                success: function(label, element) {
                    $(element).find("span.required").remove();
                }
            });
        })
    </script>
@endsection
