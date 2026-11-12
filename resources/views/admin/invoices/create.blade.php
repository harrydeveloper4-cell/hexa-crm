@extends('admin.layout.master')
@section('title', 'Invoices')

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
    <h3>{{ __('Create') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">{{ __('Orders') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.invoices.index') }}">{{ __('Invoices') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection
@section('content')
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
                                @if ($user->has_brand($brand->id) || $user->role_id == 1)
                                    <option value = "{{ $brand->id }}"
                                        data-img = "{{ asset('storage/' . $brand->logo) }}">{{ $brand->name }}
                                    </option>
                                @endif
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
                    <div class="form-group col-md-6" id = "order_id_container" style = "display:none">
                        <label for="inputPassword4">Order ID *</label>
                        <input type="text" name="order_id" id="order_id" class = "form-control" style = "display:none">
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

                <div class="form-row d-none">
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">Description *</label>
                        <textarea name="description" class="form-control" cols="60" rows="3" id = "editor">Custom Package</textarea>
                    </div>
                </div>

                <div class="form-row merchants">

                </div>

                <div class="form-row packages">


                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Sales person email *</label>
                        <input type="email" class="form-control" name="sales_email" id="sales_email">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Customer email *</label>
                        <input type="email" class="form-control" name="customer_email" id="customer_email">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Link Expiry Date *</label>
                        <input type="date" class="form-control" name="expiry_date" id="expiry_date" min="<?php echo date('Y-m-d'); ?>">
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
@endsection
@section('scripts')
@endsection
