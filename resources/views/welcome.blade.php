@extends('master')
@section('content')
    @push('style')
        <link rel="stylesheet" href="{{ asset('admin/dist/vendors/bootstrap4-toggle/css/bootstrap4-toggle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/dist/vendors/summernote/summernote-bs4.css') }}">
    @endpush
    <style>
        img {
            width: 200px;
        }

        .error {
            color: red;
        }
    </style>
    <div class = "container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class = "mt-5">
                    LINK GENERATOR FOR PAYMENT
                </h2>
                <small>
                    Please enter detail.
                </small>
                <hr />
            </div>

        </div>
        <div class = "row">
            <div class = "col-md-12">
                <form action="{{ route('order.submit') }}" method="post" id = "form">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Brand Name *</label>
                            <select class="form-control brand-select" name = "brand_name">
                                <option value = "">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option value = "{{ $brand->id }}" data-img = "{{ asset($brand->logo) }}">
                                        {{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6 logo-section" style = "display:none">
                            <label for="inputPassword4">Brand Logo</label>
                            <img src="" id="brand_logo" class = "d-block">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Payment Type</label>
                            <select class="form-control" name="payment_type" id="sale_status"
                                onchange = "select_payment_type(this.value)">
                                <option value="" selected="" disabled="">Please choose an option</option>
                                <option value="1">New Payment</option>
                                <option value="2">Up-Sale Payment</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6" id="order_id_container" style="display:none">
                            <label for="inputPassword4">Previous Order ID *</label>
                            <input type="text" name="order_id" id="order_id" class="form-control"
                                placeholder="Enter the ID of the customer's existing order">
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Amount *</label>
                            <input type="number" class="form-control" name="sale_amount" id="sale_amount" min="1">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Currency *</label>
                            <select class="form-control currency" name="sale_currency">
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputEmail4">Description *</label>
                            <textarea name="description" class="form-control" cols="60" rows="3" id = "editor"></textarea>
                        </div>
                    </div>

                    <div class="form-row merchants">

                    </div>

                    <div class="form-row packages">


                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Sales person email *</label>
                            <input type="email" class="form-control" name="sales_email" id="sales_email">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer email *</label>
                            <input type="email" class="form-control" name="customer_email" id="customer_email">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <button type="submit" class = "btn btn-primary">Submit</button>
                        </div>
                    </div>

                    <!-- Form End -->
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('admin/dist/vendors/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('admin/dist/js/summernote.script.js') }}"></script>
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

            $(document).on('change', '.brand-select', function() {
                let logo_path = $(this).find(':selected').attr('data-img');
                let brand_id = $(this).val();
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
                            $('.merchants').html(res.merchants)
                            $('.packages').html(res.packages)
                            $('.currency').html(res.currency)

                        },
                        error: function(err) {

                        }
                    })

                } else {
                    $('.merchants').html('')
                    $('.packages').html('')
                    $('.currency').html('')
                }
            })
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

        $('#form').validate({
            rules: {
                payment_type: 'required',
                sale_amount: 'required',
                description: 'required',
                brand_name: 'required',
                payment_gateway: 'required',
                'packages[]': 'required',
                sales_email: 'required',
                customer_email: 'required',
            }
        })

        $(document).ready(function() {
            if ($('#sale_status').val() == '2') {
                select_payment_type('2');
            }
        });
    </script>
@endpush
