<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ env('APP_NAME') }} - @yield('title')</title>
    @include('payment_terminals.layout.meta')
    @include('payment_terminals.layout.css')
    @if ($order->merchant_id == 5)
        <link href="{{ asset('css/merchant/normalize.css') }}">
        <link href="{{ asset('css/merchant/paymentInfo.css') }}">
    @endif
</head>

<body>
    <div id="toasts"></div>
    <div class="container">
        <div class="row m-0">
            <div class="col-md-6 col-12">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="row box-right">
                            <div class="col-md-8 ps-0 ">
                                <p class="ps-3 textmuted fw-bold h6 mb-0">TOTAL RECIEVED</p>
                                <p class="h1 fw-bold d-flex"> {{ $order->sale_currency }} <span
                                        class=" textmuted pe-1 h6 align-text-top mt-1"></span>{{ number_format($order->sale_amount, 2) }}
                                </p>
                                <p class="ms-3 px-2 bg-green">+10% since last month</p>
                            </div>
                            <div class="col-md-4">
                                <p class="p-blue"> <span class="fas fa-circle pe-2"></span>Pending </p>
                                <p class="fw-bold mb-3">
                                    {{ $order->sale_currency }}
                                    {{ number_format($order->sale_amount, 2) }} 
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 px-0 mb-4">
                        <div class="box-right">

                            <p class="textmuted h8">Invoice</p>
                            <p class="fw-bold h7">
                                {{ isset($order->brand_details) ? $order->brand_details->name : 'Auto Generated' }}</p>
                            <p class="textmuted h8">{!! $order->description !!}</p>

                            <div class="h8">
                                <div class="row m-0 border mb-3">
                                    <div class="col-6 h8 pe-0 ps-2">
                                        <p class="textmuted py-2">Items</p>
                                        @if (count($order->packages()->get()) > 0)
                                            @foreach ($order->packages()->get() as $package)
                                                <span
                                                    class="d-block py-2 border-bottom">{{ $package->package_name }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-2 text-center p-0">
                                        <p class="textmuted p-2">Qty</p>
                                        @if (count($order->packages()->get()) > 0)
                                            @foreach ($order->packages()->get() as $package)
                                                <span class="d-block py-2 border-bottom">1</span>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-2 p-0 text-center h8 border-end">
                                        <p class="textmuted p-2">Price</p>
                                        @if (count($order->packages()->get()) > 0)
                                            @foreach ($order->packages()->get() as $package)
                                                <span class="d-block py-2 border-bottom">Custom</span>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-2 p-0 text-center">
                                        <p class="textmuted p-2">Total</p>
                                        @if (count($order->packages()->get()) > 0)
                                            @foreach ($order->packages()->get() as $package)
                                                <span class="d-block py-2 border-bottom">Custom</span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="row m-0 mb-3">
                                    <div class="col-6 h8 pe-0 ps-2">
                                        <p class="textmuted py-2">Total Amount</p>
                                    </div>
                                    <div class="col-4">
                                    </div>
                                    <div class="col-2 h8 pe-0 ps-2">
                                        <p class="text-center"> {{ $order->sale_currency }}
                                            {{ number_format($order->sale_amount, 2) }}</p>
                                    </div>

                                </div>
                                <div class="h8 mb-5">
                                    <p class="textmuted">Your total amount against the selected packages are mentioned
                                        above </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12 ps-md-5 p-0 ">
                <div class="box-left">
                    <div class="">
                        <div class="card-row">
                            <span class="visa"></span>
                            <span class="mastercard"></span>
                            <span class="amex"></span>
                            <span class="discover"></span>
                        </div>
                        <p class="h7 fw-bold mb-1">Pay this Invoice</p>
                        <p class="textmuted h8 mb-2 pay-message" style = "color:red">Make payment for this invoice by
                            filling in the details</p>
                        <form class="form"
                            action="{{ $order->merchant_id == 5 ? route('rapyd.checkout') : ( $order->merchant_id == 6 ? route('chase.checkout') : route('payout') )}}"
                            method="post" id = "form">
                            @csrf
                            <input type = "hidden" id = "payment_method" name = "payment_method" value = "">
                            <input type = "hidden" id = "order_id" name = "order_id" value = "{{ $order->id }}">
                            <input type = "hidden" id = "payment_id" name = "payment_id" value = "">
                            <input type = "hidden" id = "payer_id" name = "payer_id" value = "">
                            <input type = "hidden" id = "paid_amount" name = "paid_amount" value = "">
                            <input type = "hidden" id = "last_digit" name = "last_digit" value = "">
                            <input type = "hidden" id = "response" name = "response" value = "">
                            <input type = "hidden" id = "customer_id" name = "customer_id"
                                value = "{{ isset($customer_id) ? $customer_id : '' }}">
                            <div class="row">
                                <div class="col-12 col-md-6 mt-3">
                                    <label for="inputEmail4">Amount <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control validate"
                                        value = "{{ number_format($order->sale_amount, 2) }}" name="sale_amount"
                                        id="sale_amount" required readonly>
                                </div>
                                <div class="col-12 col-md-6 mt-3">
                                    <label for="inputPassword4">Currency <span class="text-danger">*</span></label>
                                    <select class="form-control validate" name="sale_currency" id = "sale_currency">
                                        <option value="{{ $order->sale_currency }}"> {{ $order->sale_currency }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 mt-3">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('firstname') }}"
                                        class="form-control validate" name="firstname" id="firstname" required />
                                </div>
                                <div class="col-12 col-md-6 mt-3">
                                    <label>Last Name <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('lastname') }}"
                                        class="form-control validate" name="lastname" id="lastname" required />
                                </div>
                                <div class="col-12 mt-3">
                                    <label>Address (Optional)</label>
                                    <input type="text" value="{{ old('billing_address') }}"
                                        class="form-control" name="billing_address" id="billing_address"/>
                                </div>
                                <div class="col-12 col-md-6 mt-3 d-none">
                                    <label class="control-label">Country</label>
                                    <input type="hidden" value="None" name="country" required />
                                </div>
                                <div class="col-12 col-md-6 mt-3 d-none">
                                    <label>State/Province <span class="text-danger">*</span></label>
                                    <input type="text" value="None" class="form-control validate"
                                        name="state" id="state" required />
                                </div>
                                <div class="col-12 col-md-6 mt-3 d-none">
                                    <label>City <span class="text-danger">*</span></label>
                                    <input type="text" value="None" class="form-control validate"
                                        name="city" id="city" required />
                                </div>
                                <div class="col-12 col-md-6 mt-3 d-none">
                                    <label>ZIP/Postal Code <span class="text-danger">*</span></label>
                                    <input type="text" min="0" max="10" value="None"
                                        class="form-control validate" name="postalcode" id="postal_code" required />
                                </div>
                                <div class="col-12 mt-3">
                                    <label>E-mail <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control validate"
                                        value="{{ $order->customer_email }}" readonly name="email"
                                        id="billing_email" required>
                                </div>
                                <div class="col-12 mt-3">
                                    <label>Phone/Cell Number <span class="text-danger">*</span></label>
                                    <input type="tel" value="{{ old('billing_phonenumber') }}"
                                        class="form-control validate" name="billing_phonenumber" id="phonenumber"
                                        required />
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="d-grid py-4">
                                        <h2>E-Signature Capture</h2>
                                        <canvas id="signatureCanvas" style="border: 1px solid #000; width: 100%; height: 200px;">{{ $order->signature }}</canvas>
                                        <div class="buttons">
                                            <a href="javascript:void(0)" class="btn btn-danger rounded-0 btn-sm px-5" id="clearSignature">Clear</a>
                                            <a href="javascript:void(0)" class="btn btn-success rounded-0 btn-sm px-5" id="saveSignature">Save</a>
                                        </div>
                                        <div style="display: none">
                                            <h3>Base64 Signature:</h3>
                                            <textarea id="signatureBase64" name="signature" rows="5" cols="50" readonly required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-3">
                                <p class="h7 fw-bold mb-1">Pay this Invoice</p>

                                <p class="textmuted h8 mb-2 pay-message">Make payment for this invoice by filling in
                                    the details</p>
                                <div class="col-12 mt-3" id = "payment-methods" style = "display:none">

                                    @yield('content')

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modaly"><!-- Place at bottom of page --></div>
    @include('payment_terminals.layout.script')
</body>
</html>
