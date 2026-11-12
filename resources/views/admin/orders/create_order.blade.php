@extends('admin.layout.master')
@section('title', 'Orders')

@section('css')
    <style>
        #form img {
            width: 200px;
        }

        #form .error {
            color: red;
        }
    </style>
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Order Create') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><i class="icon-home mr-1"></i></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">{{ __('Orders') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <a class = "btn btn-info float-right" href = "{{ route('admin.orders.index') }}">Back</a>
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
                                <form action="{{ route('order.submit') }}" method="post" id="form">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Brand Name *</label>
                                            <select value="{{ old('brand_name') }}" class="form-control brand-select" name="brand_name">
                                                <option value="">Select Brand</option>
                                                @foreach ($brands as $brand)
                                                    @if ($user->has_brand($brand->id) || $user->role_id == 1)
                                                        <option value="{{ $brand->id }}"
                                                            {{ old('brand_name') == $brand->id ? 'selected' : '' }}
                                                            data-img="{{ asset($brand->logo) }}">
                                                            {{ $brand->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('brand_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 logo-section" style="display:none">
                                            <label for="inputPassword4">Brand Logo</label>
                                            <img src="" id="brand_logo" class="d-block">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputEmail4">Payment Type</label>
                                            <select value="{{ old('payment_types') }}" class="form-control" name="payment_type"
                                                id="sale_status" onchange ="select_payment_type(this.value)">
                                                <option value="" selected="" disabled="">Please choose an option</option>
                                                <option value="1" {{ old('payment_type') == '1' ? 'selected' : '' }}>New Payment</option>
                                                <option value="2" {{ old('payment_type') == '2' ? 'selected' : '' }}>Up-Sale Payment
                                                </option>
                                            </select>
                                            @error('payment_type')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6" id="order_id_container" style="display:none">
                                            <label for="inputPassword4">Previous Order ID *</label>
                                            <input type="text" name="order_id" id="order_id" class="form-control"
                                                value="{{ old('order_id') }}"
                                                placeholder="Enter the ID of the customer's existing order">
                                            @error('order_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label for="inputEmail4">Amount *</label>
                                            <input type="number" value="{{ old('sale_amount') }}" class="form-control" name="sale_amount"
                                                id="sale_amount" min="1">
                                            @error('sale_amount')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">Currency *</label>
                                            <select value="{{ old('sale_currency') }}" class="form-control currency" name="sale_currency">
                                            </select>
                                            @error('sale_currency')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row d-none">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail4">Description *</label>
                                            <textarea name="description" class="form-control" cols="60" rows="3" id="editor">Custom Package</textarea>
                                        </div>
                                    </div>

                                    <div class="form-row merchants">
                                        @error('merchants')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>

                                    <div class="form-row packages border p-3 mb-3">
                                        @error('packages')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Sales person email *</label>
                                            <input type="email"
                                                value="{{ old('sales_email', !empty($is_staff_user) ? $user->email : '') }}"
                                                class="form-control" name="sales_email" id="sales_email"
                                                {{ !empty($is_staff_user) ? 'readonly' : '' }}>
                                            @error('sales_email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Customer email *</label>
                                            <input type="email" value="{{ old('customer_email') }}" class="form-control"
                                                name="customer_email" id="customer_email">
                                            @error('customer_email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 d-none">
                                            <label>Link Expiry Date *</label>
                                            <input type="date" value="{{ old('expiry_date') }}" class="form-control" name="expiry_date"
                                                id="expiry_date" min="<?php echo date('Y-m-d'); ?>">
                                            @error('expiry_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>

                                    <!-- Form End -->
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
        // Show / hide the "Previous Order ID" field based on the selected payment type.
        function select_payment_type(value) {
            if (value == '2') {
                $('#order_id_container').show();
                $('#order_id').rules('add', {
                    required: true,
                    messages: {
                        required: 'Previous order ID is required for Up-Sale payment.'
                    }
                });
            } else {
                $('#order_id').rules('remove', 'required');
                $('#order_id').val('');
                $('#order_id_container').hide();
            }
        }

        $(document).ready(function() {
            // $(document).on('change', '.brand-select', function() {
            //     let logo_path = $(this).find(':selected').attr('data-img');
            //     let brand_id = $(this).val();
            //     if (logo_path != '' && logo_path != undefined) {
            //         $('#brand_logo').attr('src', logo_path);
            //         $('.logo-section').show();
            //     } else {
            //         $('#brand_logo').attr('src', '');
            //         $('.logo-section').hide();
            //     }
            //     if (brand_id != '') {
            //         console.log("Inside the if condition");
            //         $.ajax({
            //             url: "{{ route('brand.merchant.packages') }}",
            //             type: "POST",
            //             data: {
            //                 '_token': "{{ csrf_token() }}",
            //                 brand_id: brand_id
            //             },
            //             success: function(res) {
            //                 $('.merchants').html(res.merchants)
            //                 $('.packages').html(res.packages)
            //                 $('.currency').html(res.currency)
            //             },
            //             error: function(err) {}
            //         })

            //     } else {
            //         $('.merchants').html('')
            //         $('.packages').html('')
            //         $('.currency').html('')
            //     }
            // });
        });

        $(document).ready(function() {
            function fetchBrandDetails(brand_id) {
                let logo_path = $('.brand-select').find(':selected').attr('data-img');
                if (logo_path != '' && logo_path != undefined) {
                    $('#brand_logo').attr('src', logo_path);
                    $('.logo-section').show();
                } else {
                    $('#brand_logo').attr('src', '');
                    $('.logo-section').hide();
                }
                if (brand_id != '') {
                    $.ajax({
                        url: "{{ route('brand.merchant.packages') }}",
                        type: "POST",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            brand_id: brand_id
                        },
                        success: function(res) {
                            $('.merchants').html(res.merchants);
                            $('.packages').html(res.packages);
                            $('.currency').html(res.currency);
                        },
                        error: function(err) {
                            console.log(err);
                            
                            // if(err.status === 422){
                            //     let errors = err.response
                            // }
                        }
                    });
                } else {
                    $('.merchants').html('');
                    $('.packages').html('');
                    $('.currency').html('');
                }
            }

            $(document).on('change', '.brand-select', function() {
                let brand_id = $(this).val();
                fetchBrandDetails(brand_id);
            });

            if ($('.brand-select').val() != '') {
                fetchBrandDetails($('.brand-select').val());
            }
        });

        $(document).ready(function() {
            $('#editor').summernote();
        });

        $('#form').submit(function() {

            // // Get the Login Name value and trim it
            var editor = $.trim($('#editor').val());
            console.log(editor);

            // Check if empty of not
            if (editor === '') {
                // alert('description field is empty.');
                return false;
            }
        });


        $(document).ready(function() {
            $('#form').validate({
                rules: {
                    brand_name: {
                        required: true
                    },
                    payment_type: {
                        required: true
                    },
                    sales_email: {
                        required: true,
                        email: true
                    },
                    customer_email: {
                        required: true,
                        email: true
                    },
                    expiry_date: {
                        required: true,
                        date: true
                    },
                    sale_amount: {
                        required: true,
                        number: true,
                        min: 1
                    },
                    sale_currency: {
                        required: true,
                    },
                    payment_gateway: {
                        required: true,
                    },
                    'packages[]' :{
                        required: true
                    }
                },
                messages: {
                    brand_name: {
                        required: "Please select a brand."
                    },
                    payment_type: {
                        required: "Please select the payment type"
                    },
                    sales_email: {
                        required: "Salesperson email is required.",
                        email: "Please enter a valid email address."
                    },
                    customer_email: {
                        required: "Customer email is required.",
                        email: "Please enter a valid email address."
                    },
                    expiry_date: {
                        required: "Link expiry date is required.",
                        date: "Please enter a valid date."
                    },
                    sale_amount: {
                        required: "Amount is required.",
                        number: "Please enter a valid number.",
                        min: "Amount must be greater than zero."
                    },
                    sale_currency: {
                        required: "Currency is required"
                    },
                    payment_gateway: {
                        required: "Please select the payment type"
                    },
                    'packages[]' :{
                        required: "You must check at least 1 box"
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.is('select')) {
                        error.appendTo(element.parents('.form-group'));
                    }
                    if(element.is(":radio")){
                        error.appendTo(element.parents('.merchants')); 
                    }
                    else {
                        error.addClass('text-danger');
                        error.append('<span class="required text-danger">*</span>');
                        error.insertAfter(element);
                    }
                },
                success: function(label, element) {
                    if ($(element).is('select')) {
                        label.remove();
                    }
                }
            });
            $('select[name="brand_name"]').on('change', function() {
                var $this = $(this);
                if ($this.val() !== "") {
                    $this.parents('.form-group').find('label.error').remove();
                }
            });
            $('select[name="payment_type"]').on('change', function() {
                var $this = $(this);
                if ($this.val() !== "") {
                    $this.parents('.form-group').find('label.error').remove();
                }
            });

            // Restore the Up-Sale field when the form is re-rendered with errors.
            if ($('#sale_status').val() == '2') {
                select_payment_type('2');
            }
        });
    </script>
@endsection
