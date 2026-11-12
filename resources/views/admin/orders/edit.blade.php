@extends('admin.layout.master')
@section('title', 'Orders')

@section('css')

@endsection

@section('breadcrumb-title')
    <h3>{{ __('Brand Edit') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><i class="icon-home mr-1"></i></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">{{ __('Orders') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Edit') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <a class = "btn btn-info float-right" href = "{{ route('admin.orders.index') }}">Back</a>
        </div>
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">{{ 'Order# ' . $order->order_number }}</h6>
                    @if (!is_null($order->payment_link))
                        <a class = "btn btn-warning btn-s float-right mx-3" style="color: #fff;"
                            href = "{{ $order->payment_link }}" target = "_blank">Payment Link</a>
                    @endif
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form action = "{{ route('admin.orders.update', ['id' => $order->id]) }}" method = "POST"
                                    id = "order-form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Payment Type</label>
                                            <select class="form-control" name="payment_type" id="sale_status" required=""
                                                onchange = "select_payment_type(this.value)">
                                                <option value="" selected="" disabled="">Please choose an option
                                                </option>
                                                <option value="1" {{ $order->payment_type == '1' ? 'selected' : '' }}>
                                                    New
                                                    Payment</option>
                                                <option value="2" {{ $order->payment_type == '2' ? 'selected' : '' }}>
                                                    Up-Sale Payment</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6" id = "order_id_container">
                                            <label for="inputPassword4">Order ID *</label>
                                            <input type="text" name="order_id" id="order_id" class = "form-control"
                                                value = "{{ $order->order_number }}" readonly>
                                        </div>
                                    </div>


                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Amount *</label>
                                            <input type="number" class="form-control" name="sale_amount" id="sale_amount"
                                                required="" min="1" value = "{{ $order->sale_amount ?? '' }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputPassword4">Currency *</label>
                                            <select class="form-control" name="sale_currency">
                                                <option value="USD"
                                                    {{ $order->sale_currency == 'USD' ? 'selected' : '' }}>
                                                    USD</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputEmail4">Description *</label>
                                            <textarea name="description" class="form-control" cols="60" rows="3">{{ $order->description ?? '' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input type = "hidden" name = "brand_name" value = "{{ $order->brand_name }}">
                                            <label for="inputEmail4">Brand Name *</label>
                                            <select class="form-control brand-select" name = "brand_name" required disabled>
                                                <option value = "">Select Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option value = "{{ $brand->id }}"
                                                        {{ $order->brand_name == $brand->id ? 'selected' : '' }}
                                                        data-img = "{{ asset($brand->logo) }}">
                                                        {{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 logo-section">
                                            <label for="inputPassword4">Brand Logo</label>
                                            <img src="{{ asset($brand->logo) }}" width="100"
                                                id="brand_logo" class = "d-block">
                                        </div>
                                    </div>

                                    <div class="form-row packages border p-3 mb-3">
                                        <div class="col-md-12">
                                            <h4>
                                                Select Package
                                            </h4>
                                        </div>
                                        @php
                                            $order_packages = $order->order_packages->pluck('package_id')->toArray();
                                        @endphp

                                        @foreach ($brand_packages as $package)
                                            <div class="col-md-4">
                                                <input type="checkbox" id="pack{{ $package->id }}" name="packages[]"
                                                    value="{{ $package->id }}"
                                                    {{ in_array($package->id, $order_packages) ? 'checked' : '' }}>
                                                <label for="pack{{ $package->id }}">{{ $package->package_name }}</label>
                                            </div>
                                        @endforeach

                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Sales person email *</label>
                                            <input type="email" class="form-control" name="sales_email" id="sales_email"
                                                required="" value = "{{ $order->sales_email }}" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Customer email *</label>
                                            <input type="email" class="form-control" name="customer_email"
                                                id="customer_email" required=""
                                                value = "{{ $order->customer_email }}" readonly>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <button type="submit" class = "btn btn-primary">Submit</button>
                                        </div>
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
            $('#order-form').validate({
                rules: {
                    name: 'required',
                    description: 'required',
                    logo: {
                        required: true,
                        extension: "jpg|jpeg|png|bmp"
                    },
                    link: 'required',
                    merchants: 'required'
                }
            })
        })
    </script>
@endsection
