<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{$order->brand_details->name}}</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ asset('script.js') }}"></script>
    @if ($order->merchant_id == 5)
        <link href="{{ asset('css/merchant/normalize.css') }}">
        <link href="{{ asset('css/merchant/paymentInfo.css') }}">
    @endif

    <style>
        .error {
            display: none;
            color: red;
        }

        #error-msg {
            color: red;
        }

        #success-msg {
            color: green;
        }



        .custom-toast {
            display: flex;
            align-items: center;
        }

        .custom-toast img {
            background-size: 50px 50px;
            height: 50px;
            width: 50px;
        }

        .custom-toast p {
            font-size: 14px;
            padding: 10px;
        }

        /* ---- end demo code ---- */

        #toasts {
            min-height: 0;
            position: fixed;
            right: 20px;
            top: 20px;
            width: 400px;
        }

        #toasts .toast {
            background: #d6d8d9;
            border-radius: 3px;
            box-shadow: 2px 2px 3px rgba(0, 0, 0, .1);
            color: rgba(0, 0, 0, .6);
            cursor: default;
            margin-bottom: 20px;
            opacity: 0;
            position: relative;
            padding: 20px;
            transform: translateY(15%);
            transition: opacity .5s ease-in-out, transform .5s ease-in-out;
            width: 100%;
            will-change: opacity, transform;
            z-index: 1100;
        }

        #toasts .toast.success {
            background: #26d68a;
        }

        #toasts .toast.warning {
            background: #ffa533;
        }

        #toasts .toast.info {
            background: #2cbcff;
        }

        #toasts .toast.error {
            background: #f44336;
        }

        #toasts .toast.show {
            opacity: 1;
            transform: translateY(0);
            transition: opacity .5s ease-in-out, transform .5s ease-in-out;
        }

        #toasts .toast.hide {
            height: 0;
            margin: 0;
            opacity: 0;
            overflow: hidden;
            padding: 0 30px;
            transition: all .5s ease-in-out;
        }

        #toasts .toast .close {
            cursor: pointer;
            font-size: 24px;
            height: 16px;
            margin-top: -10px;
            position: absolute;
            right: 14px;
            top: 50%;
            width: 16px;
        }
    </style>
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
                                <p class="fw-bold mb-3">{{ $order->sale_currency }}
                                    {{ number_format($order->sale_amount, 2) }} </p>
                                <!--<p class="p-org"><span class="fas fa-circle pe-2"></span>On drafts</p>-->

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
                            action="{{ $order->merchant_id == 5 ? route('rapyd.checkout') : route('payout') }}"
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
                                    <label for="inputEmail4">Amount *</label>
                                    <input type="text" class="form-control validate"
                                        value = "{{ number_format($order->sale_amount, 2) }}" name="sale_amount"
                                        id="sale_amount" required readonly>
                                </div>
                                <div class="col-12 col-md-6 mt-3">
                                    <label for="inputPassword4">Currency *</label>
                                    <select class="form-control validate" name="sale_currency" id = "sale_currency">
                                        <option value="{{ $order->sale_currency }}"> {{ $order->sale_currency }}
                                        </option>
                                        {{--
                            <option value="USD" {{ $order->sale_currency == 'USD'?'selected':'' }}> USD</option>
                            <option value="GBP" {{ $order->sale_currency == 'GBP'?'selected':'' }}> GBP</option>
                            --}}
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 mt-3">
                                    <label>First Name *</label>
                                    <input type="text" value="{{ old('firstname') }}"
                                        class="form-control validate" name="firstname" id="firstname" required />
                                </div>
                                <div class="col-12 col-md-6 mt-3">
                                    <label>Last Name *</label>
                                    <input type="text" value="{{ old('lastname') }}"
                                        class="form-control validate" name="lastname" id="lastname" required />
                                </div>
                                <div class="col-12 mt-3">
                                    <label>Address *</label>
                                    <input type="text" value="{{ old('billing_address') }}"
                                        class="form-control validate" name="billing_address" id="billing_address"
                                        required />
                                </div>
                                <div class="col-12 col-md-6 mt-3 d-none">
                                    <label class="control-label">Country</label>
                                    <input type="hidden" value="None" name="country" required />
                                    {{--
                                    <select id="country" name="country" class="form-control validate" required>
                                        @foreach (get_countries() as $country)
                                        <option value="{{ $country }}" @if (old('lastname') == $country) selected @endif>{{ $country }}</option>
                                        @endforeach
                                    </select>                            
                                    --}}
                                </div>
                                <div class="col-12 col-md-6 mt-3 d-none">
                                    <label>State/Province *</label>
                                    <input type="text" value="None" class="form-control validate"
                                        name="state" id="state" required />
                                </div>
                                <div class="col-12 col-md-6 mt-3 d-none">
                                    <label>City *</label>
                                    <input type="text" value="None" class="form-control validate"
                                        name="city" id="city" required />
                                </div>
                                <div class="col-12 col-md-6 mt-3 d-none">
                                    <label>ZIP/Postal Code *</label>
                                    <input type="text" min="0" max="10" value="None"
                                        class="form-control validate" name="postalcode" id="postal_code" required />
                                </div>
                                <div class="col-12 mt-3">
                                    <label>E-mail *</label>
                                    <input type="email" class="form-control validate"
                                        value="{{ $order->customer_email }}" readonly name="email"
                                        id="billing_email" required>
                                </div>

                                <div class="col-12 mt-3">
                                    <label>Phone/Cell Number *</label>
                                    <input type="tel" value="{{ old('billing_phonenumber') }}"
                                        class="form-control validate" name="billing_phonenumber" id="phonenumber"
                                        required />
                                </div>
                                <hr class="my-3">
                                <p class="h7 fw-bold mb-1">Pay this Invoice</p>

                                <p class="textmuted h8 mb-2 pay-message">Make payment for this invoice by filling in
                                    the details</p>
                                <div class="col-12 mt-3" id = "payment-methods" style = "display:none">
                                    @if ($order->merchant_id == 1)
                                        <div id = "paypal-button-container-popup"></div>
                                    @elseif($order->merchant_id == 2)
                                        <div id="card-element"></div>

                                        <?php
                                        $is_hider = 0;
                                        if($is_hider == 1){
                                        ?>

                                        <div class="form-row row">
                                            <div class="col-xs-12 form-group required"><label
                                                    class="control-label">Name on Card</label> <input
                                                    class="form-control" size="4" type="text"
                                                    name="owner" /></div>
                                        </div>
                                        <div class="form-row row">
                                            <div class="col-xs-12 form-group card required">
                                                <label class="control-label">Card Number</label> <input
                                                    autocomplete="off" class="form-control card-number"
                                                    data-ng-minlength="19" maxlength="19" inputmode="numeric"
                                                    placeholder="4242 4242 4242 4242" name="cardNumber"
                                                    type="text" />
                                            </div>
                                        </div>
                                        <div class="form-row row">
                                            <div class="col-xs-12 col-md-4 form-group cvc required"><label
                                                    class="control-label">CVC</label> <input autocomplete="off"
                                                    class="form-control card-cvc" name="cvv"
                                                    placeholder="ex. 311" size="4" type="text" /></div>

                                            <div class="col-xs-12 col-md-4 form-group expiration required">
                                                <label class="control-label">Expiration Month</label>

                                                <select class="form-control card-expiry-month"
                                                    name="expiration-month">
                                                    <option value="01">January</option>

                                                    <option value="02">February </option>

                                                    <option value="03">March</option>

                                                    <option value="04">April</option>

                                                    <option value="05">May</option>

                                                    <option value="06">June</option>

                                                    <option value="07">July</option>

                                                    <option value="08">August</option>

                                                    <option value="09">September</option>

                                                    <option value="10">October</option>

                                                    <option value="11">November</option>

                                                    <option value="12">December</option>
                                                </select>

                                                {{-- <input class="form-control card-expiry-month" placeholder="MM" size="2" type="text" /> --}}
                                            </div>

                                            <div class="col-xs-12 col-md-4 form-group expiration required">
                                                <label class="control-label">Expiration Year</label>

                                                {{-- <input class="form-control card-expiry-year" placeholder="YYYY" size="4" type="text" /> --}}

                                                <select class="form-control card-expiry-year" name="expiration-year">
                                                    @php
                                                        $year = date('Y');
                                                        $limit = 10 + $year;
                                                    @endphp @for ($i = $year; $i < $limit; $i++)
                                                        <option value="{{ $i }}">{{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <!-- HERE -->
                                        </div>

                                        <?php
                                        }
                                        ?>

                                        <div id="card-errors" style="color: red;"></div>
                                        <div id="card-thank" style="color: green;"></div>
                                        <div id="card-message" style="color: green;"></div>
                                        <div id="card-success" style="color: green;font-weight:bolder"></div>




                                        <div class='col-xs-12 col-md-12 form-group'>
                                            <input type="submit" class = "btn btn-primary d-block h8"
                                                value = "Pay with Stripe" id = "checkout-button">
                                        </div>
                                    @elseif($order->merchant_id == 3)
                                        <form id="payment-form">
                                            <div id="card-container"></div>
                                            <button id="card-button" class = "btn btn-primary d-block h8"
                                                type="button">PAY <span
                                                    class="fas fa-dollar-sign ms-2"></span>{{ number_format($order->sale_amount, 2) }}<span
                                                    class="ms-3 fas fa-arrow-right"></span></button>
                                        </form>
                                        <div id="payment-status-container"></div>
                                    @elseif($order->merchant_id == 4)
                                        @php
                                            $months = [
                                                1 => 'Jan',
                                                2 => 'Feb',
                                                3 => 'Mar',
                                                4 => 'Apr',
                                                5 => 'May',
                                                6 => 'Jun',
                                                7 => 'Jul',
                                                8 => 'Aug',
                                                9 => 'Sep',
                                                10 => 'Oct',
                                                11 => 'Nov',
                                                12 => 'Dec',
                                            ];
                                        @endphp
                                        <div class="row">
                                            <div class = "col-md-12">
                                                <span id = "error-msg" style = "display:none"></span>
                                                <span id = "success-msg" style = "display:none"></span>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="form-group owner col-md-8">
                                                <label for="owner">Owner</label>
                                                <input type="text" class="form-control" id="owner"
                                                    name="owner" value="{{ old('owner') }}" required>
                                                <span id="owner-error" class="error text-red">Please enter owner
                                                    name</span>
                                            </div>
                                            <div class="form-group CVV col-md-4">
                                                <label for="cvv">CVV</label>
                                                <input type="text" class="form-control" id="cvv"
                                                    name="cvv" value="{{ old('cvv') }}" required>
                                                <span id="cvv-error" class="error text-red">Please enter cvv</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-8" id="card-number-field">
                                                <label for="cardNumber">Card Number</label>
                                                <input type="text" class="form-control" id="cardNumber"
                                                    name="cardNumber" value="{{ old('cardNumber') }}" required>
                                                <span id="show-cc-label"></span>
                                                <span id="card-error" class="error text-red">Please enter valid card
                                                    number</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6" id="expiration-date">
                                                <label>Expiration Date</label><br />
                                                <select class="form-control" id="expiration-month"
                                                    name="expiration-month"
                                                    style="float: left; width: 100px; margin-right: 10px;">

                                                    <option value="01">January</option>

                                                    <option value="02">February </option>

                                                    <option value="03">March</option>

                                                    <option value="04">April</option>

                                                    <option value="05">May</option>

                                                    <option value="06">June</option>

                                                    <option value="07">July</option>

                                                    <option value="08">August</option>

                                                    <option value="09">September</option>

                                                    <option value="10">October</option>

                                                    <option value="11">November</option>

                                                    <option value="12">December</option>
                                                </select>
                                                <select class="form-control" id="expiration-year"
                                                    name="expiration-year" style="float: left; width: 100px;">

                                                    @for ($i = date('Y'); $i <= date('Y') + 15; $i++)
                                                        <option value="{{ $i }}">{{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6" id="credit_cards"
                                                style="margin-top: 22px;">
                                                <img src="{{ asset('images/visa.png') }}" id="visa">
                                                <img src="{{ asset('images/mastercard.png') }}" id="mastercard">
                                                <img src="{{ asset('images/amex.jpg') }}" id="amex"
                                                    width = "40" height = "25">
                                            </div>
                                        </div>

                                        <br />
                                        <div class="form-group" id="pay-now">
                                            <button type="button" class="btn btn-success themeButton"
                                                id="pay-authorize">Pay with Authorize.net</button>
                                        </div>
                                    @elseif($order->merchant_id == 5)
                                        <div class="form-group" id="pay-now">
                                            <div class="form-row row">
                                                <div class="col-xs-12 form-group required"><label
                                                        class="control-label">Name on Card</label> <input required
                                                        class="form-control" size="4" type="text"
                                                        name="card_holder_name" /></div>
                                            </div>

                                            <div class="form-row row">
                                                <div class="col-xs-12 form-group required"><label
                                                        class="control-label">Card Number</label> <input required
                                                        autocomplete="off" class="form-control card-number"
                                                        name="card_number" size="20" type="text" /></div>
                                            </div>

                                            <div class="form-row row">
                                                <div class="col-xs-12 col-md-4 form-group cvc required"><label
                                                        class="control-label">CVC</label> <input required
                                                        autocomplete="off" class="form-control card-cvc"
                                                        name="cvv_number" placeholder="ex. 311" size="4"
                                                        type="text" /></div>

                                                <div class="col-xs-12 col-md-4 form-group expiration required">
                                                    <label class="control-label">Expiration Month</label>

                                                    <select class="form-control card-expiry-month" name="exp_month"
                                                        required>
                                                        <option value="01">January</option>

                                                        <option value="02">February </option>

                                                        <option value="03">March</option>

                                                        <option value="04">April</option>

                                                        <option value="05">May</option>

                                                        <option value="06">June</option>

                                                        <option value="07">July</option>

                                                        <option value="08">August</option>

                                                        <option value="09">September</option>

                                                        <option value="10">October</option>

                                                        <option value="11">November</option>

                                                        <option value="12">December</option>
                                                    </select>

                                                    {{-- <input class="form-control card-expiry-month" placeholder="MM" size="2" type="text" /> --}}
                                                </div>

                                                <div class="col-xs-12 col-md-4 form-group expiration required">
                                                    <label class="control-label">Expiration Year</label>

                                                    {{-- <input class="form-control card-expiry-year" placeholder="YYYY" size="4" type="text" /> --}}

                                                    <select class="form-control card-expiry-year" name="exp_year"
                                                        required>
                                                        @php
                                                            $year = date('Y');
                                                            $limit = 10 + $year;
                                                        @endphp @for ($i = $year; $i < $limit; $i++)
                                                            <option value="{{ substr($i, -2) }}">{{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>


                                            </div>




                                            <div class="form-row row">
                                                <button type="submit" class="btn btn-success themeButton mt-5"
                                                    id="pay-rapyd">Pay with Rapyd</button>
                                            </div>

                                        </div>

                                    @endif
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modaly"><!-- Place at bottom of page --></div>
    <!-- <script src="https://js.stripe.com/v3/"></script> -->
    <!--<script src="https://checkout.stripe.com/checkout.js"></script>-->
    {{-- 
<!-- Start of  Zendesk Widget script -->
<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=51fbfae2-f854-4e49-9f69-156f104064e6"> </script>
<!-- End of  Zendesk Widget script -->
<script>
zE(function() {
    $zopim(function() {
      $zopim.livechat.setOnUnreadMsgs(unread);
        function unread(number) {
        if (number>=1)
        {
      $zopim.livechat.window.show();
        }
        }
    });
});
</script> --}}
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <style>
        .modaly {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(255, 255, 255, .8) url('{{ asset('images/spin.gif') }}') 50% 50% no-repeat;
        }

        /* When the body has the loading class, we turn
           the scrollbar off with overflow:hidden */
        body.loading .modaly {
            overflow: hidden;
        }

        /* Anytime the body has the loading class, our
           modal element will be visible */
        body.loading .modaly {
            display: block;
        }
    </style>
    @if (env('SquareUP_ENVIRONMENT') == 'sandbox')
        <script type="text/javascript" src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
    @elseif(env('SquareUP_ENVIRONMENT') == 'production')
        <script type="text/javascript" src="https://web.squarecdn.com/v1/square.js"></script>
    @endif

    @if ($order->merchant_id == 5)
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    @endif

    @if ($order->merchant_id == 1)
        @php
            $config_keys = json_decode(get_merchant_keys($order->brand_name, $order->merchant_id));
        @endphp
        <script
            src="https://www.paypal.com/sdk/js?client-id={{ $config_keys->client_id }}&currency={{ $currency_mode }}&components=buttons">
        </script>
        <script>
            $(document).ready(function() {
                //var amount = $('#sale_amount').val();
                var amount = "{{ $order->sale_amount }}";

                paypal.Buttons({
                    style: {
                        layout: 'vertical',
                        size: 'responsive',
                        color: 'gold',
                        shape: 'rect',
                        label: 'paypal',

                    },
                    env: "{{ env('PAYPAL_ENVIRONMENT') }}", //sandbox // production
                    createOrder: function(data, actions) {
                        // This function sets up the details of the transaction, including the amount and line item details.
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: amount
                                }
                            }]
                        });
                    },
                    onApprove: function(data, actions) {
                        // This function captures the funds from the transaction.
                        return actions.order.capture().then(function(details) {
                            // This function shows a transaction success message to your buyer.      
                            let dataString = JSON.stringify(details.purchase_units);
                            $('#payment_method').val('paypal')
                            $('#payment_id').val(details.id)
                            $('#payer_id').val(details.payer.payer_id)
                            $('#paid_amount').val(amount)
                            $('#last_digit').val('')
                            $('#response').val(dataString)
                            $('#form').submit()
                            // toastr.success('Payment has been processed successfully..!');
                        });
                    },

                    onCancel: function(data) {
                        // Show a cancel page, or return to cart
                        alert('Payment process has been cancelled')
                    },

                    onError: function(err) {
                        console.log(err)
                        // For example, redirect to a specific error page
                        alert('Your payment cannot be process, Please try again later.')
                    }

                }).render('#paypal-button-container-popup');

            })
        </script>
    @elseif($order->merchant_id == 2)
        <script scr="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
        <script src="https://js.stripe.com/v3/"></script>
        @php
            $config_keys = json_decode(get_merchant_keys($order->brand_name, $order->merchant_id));

        @endphp

        <script>
            var stripe_key = "{{ $config_keys->stripe_key }}";
            var secret_key = "{{ $config_keys->stripe_secret_key }}";

            var nameb;
            var emailb;
            $(document).ready(function() {

                $("#firstname").change(function() {
                    nameb = $("#firstname").val();
                });

                emailb = $("#billing_email").val();
            });

            $('#card-success').text('');
            $('#card-errors').text('');
            var stripe = Stripe(stripe_key);
            var elements = stripe.elements();
            $('#submit').prop('disabled', true);
            // Set up Stripe.js and Elements to use in checkout form
            var style = {
                base: {
                    color: "#32325d",
                }
            };

            var card = elements.create("card", {
                style: style
            });
            card.mount("#card-element");


            card.addEventListener('change', ({
                error
            }) => {
                const displayError = document.getElementById('card-errors');
                if (error) {
                    displayError.textContent = error.message;
                    $('#submit').prop('disabled', true);

                } else {
                    displayError.textContent = '';
                    $('#submit').prop('disabled', false);

                }
            });

            var form = document.getElementById('form');

            form.addEventListener('submit', function(ev) {

                $('.modaly').css('display', 'block');

                ev.preventDefault();
                //cardnumber,exp-date,cvc



                stripe.confirmCardPayment('{{ $data['client_secret'] }}', {
                    payment_method: {
                        card: card,
                        billing_details: {
                            name: nameb,
                            email: emailb
                        }
                    },
                    setup_future_usage: 'off_session'
                }).then(function(result) {



                    if (result.error) {

                        $('#card-errors').text(result.error.message);
                        $('.modaly').css('display', 'none');

                    } else {
                        if (result.paymentIntent.status === 'succeeded') {
                            $('#payment_method').val('Stripe 3DS')
                            var payment_intent_id = result.paymentIntent.id;
                            var response_data = result.paymentIntent;
                            $("#payment_id").val(payment_intent_id);
                            $("#payer_id").val(payment_intent_id);
                            $('#paid_amount').val((result.paymentIntent.amount / 100))
                            var data_parse = JSON.stringify(response_data, null, 2);
                            $("#response").val(data_parse);

                            $('#card-success').text("payment successfully completed.");

                            console.log(card);
                            console.log("payment_intent_id  = " + payment_intent_id);
                            console.log("response_data  = " + data_parse);
                            $("#form").submit();
                        }
                        return false;
                    }
                });
            });
        </script>
        {{--
<script>
// let ccNumberInput = document.querySelector('.card-number'),
// 		ccNumberPattern = /^\d{0,16}$/g,
// 		ccNumberSeparator = " ",
// 		ccNumberInputOldValue,
// 		ccNumberInputOldCursor,
		
		
// 	ccCVCInput = document.querySelector('.card-cvc'),
// 		ccCVCPattern = /^\d{0,3}$/g,
		
// 		mask = (value, limit, separator) => {
// 			var output = [];
// 			for (let i = 0; i < value.length; i++) {
// 				if ( i !== 0 && i % limit === 0) {
// 					output.push(separator);
// 				}
				
// 				output.push(value[i]);
// 			}
			
// 			return output.join("");
// 		},
// 		unmask = (value) => value.replace(/[^\d]/g, ''),
// 		checkSeparator = (position, interval) => Math.floor(position / (interval + 1)),
// 		ccNumberInputKeyDownHandler = (e) => {
// 			let el = e.target;
// 			ccNumberInputOldValue = el.value;
// 			ccNumberInputOldCursor = el.selectionEnd;
// 		},
// 		ccNumberInputInputHandler = (e) => {
// 			let el = e.target,
// 					newValue = unmask(el.value),
// 					newCursorPosition;
			
// 			if ( newValue.match(ccNumberPattern) ) {
// 				newValue = mask(newValue, 4, ccNumberSeparator);
				
// 				newCursorPosition = 
// 					ccNumberInputOldCursor - checkSeparator(ccNumberInputOldCursor, 4) + 
// 					checkSeparator(ccNumberInputOldCursor + (newValue.length - ccNumberInputOldValue.length), 4) + 
// 					(unmask(newValue).length - unmask(ccNumberInputOldValue).length);
				
// 				el.value = (newValue !== "") ? newValue : "";
// 			} else {
// 				el.value = ccNumberInputOldValue;
// 				newCursorPosition = ccNumberInputOldCursor;
// 			}
			
// 			el.setSelectionRange(newCursorPosition, newCursorPosition);
			
// 			highlightCC(el.value);
// 		},
// 		highlightCC = (ccValue) => {
// 			let ccCardType = '',
// 					ccCardTypePatterns = {
// 						amex: /^3/,
// 						visa: /^4/,
// 						mastercard: /^5/,
// 						disc: /^6/,
						
// 						genric: /(^1|^2|^7|^8|^9|^0)/,
// 					};
			
// 			for (const cardType in ccCardTypePatterns) {
// 				if ( ccCardTypePatterns[cardType].test(ccValue) ) {
// 					ccCardType = cardType;
// 					break;
// 				}
// 			}
			
// 			let activeCC = document.querySelector('.cc-types__img--active'),
// 					newActiveCC = document.querySelector(`.cc-types__img--${ccCardType}`);
			
// 			if (activeCC) activeCC.classList.remove('cc-types__img--active');
// 			if (newActiveCC) newActiveCC.classList.add('cc-types__img--active');
// 		}

// ccNumberInput.addEventListener('keydown', ccNumberInputKeyDownHandler);
// ccNumberInput.addEventListener('input', ccNumberInputInputHandler);





// function pay(){
    
//     // var stripe_key = "{{$config_keys->stripe_key}}";
//     // var secret_key = "{{$config_keys->stripe_secret_key}}";    
     
//      var stripe_key = "pk_test_51KjcskGxYNiOs7jLtogbXloyHdwkyFH2LQ56iQQbh0DkXzeOL0DKZ1f3JJ1fdrXkl3bWfeyObiobrQBSnEsqE1Z000PXz4j5JT";
//      var secret_key = "sk_test_51KjcskGxYNiOs7jL3EIC28sVnFSl9SDjwJpZT9hjrk5okOaysNMBpYBCcsqldi8jiQItlDVZtidGVGhFgd2hDgeZ00gU57IZJl";
     
//     // var stripe_key = "pk_test_51JLEABHp3dFXYI5tFIp2RCQqCSDBART8mH4DsUuZ2pEEZn6zBC8Qu3vyJiPMOEZsL4tSsDbpI3jyib712AX8uhyy00lti3M11l";
//     // var secret_key = "sk_test_51JLEABHp3dFXYI5tM0HRVjZzXGfnlPU0t6ieRmOUEooGJ33JenoZa366jAoPThF2JyZOsJwZawA4u7m7oAavBdHn004eykG4NS";

//     Stripe.setPublishableKey(stripe_key);

//       Stripe.createToken({

//         number: $('.card-number').val(),

//         cvc: $('.card-cvc').val(),

//         exp_month: $('.card-expiry-month').val(),

//         exp_year: $('.card-expiry-year').val()

//       }, stripeResponseHandler);
      
//         function stripeResponseHandler(status, response) {

//         if (response.error) {

//             $('.error')

//                 .removeClass('hide')

//                 .find('.alert')

//                 .text(response.error.message);

//               //  $body.removeClass("loading");

//                 alert(response.error.message)
//                 toastr.error(response.error.message);
//                 //generateNotification(0,response.error.message);

//                 return false;

//         } else {

//             // token contains id, last4, and card type
//             //console.log(response)
//             let token = response['id'];
//             let amount = $('#sale_amount').val();
//             let sale_currency = $('#sale_currency').val();
//             let brand_name = "{{isset($order->brand_details)?$order->brand_details->name:'Auto Generated'}}";
            
//             $.ajax({
//                 url:"{{ route('stripe.checkout') }}",
//                 type:"POST",
//                 data:{'_token':"{{ csrf_token() }}",amount:amount,sale_currency:sale_currency,stripeToken:token,brand_name:brand_name,secret_key:secret_key},
//                 success:function(res){


//             $('#payment_method').val('stripe')
//             $('#payment_id').val(res.payment_id)
//             $('#payer_id').val(res.payer_id)
//             $('#paid_amount').val(res.paid_amount)
//             $('#last_digit').val(res.last4)
//             $('#response').val(res.response)
//             $('#form').submit()
//             toastr.success('Payment has been processed successfully..!');
//                 },
//                 error:function(err){
//                     alert('Payment process failed : ' +err.responseJSON.msg);
//                     console.log(err.responseJSON.msg);
//                 }
//             })


//         }

//     }
// }    
</script>
--}}
    @elseif($order->merchant_id == 3)
        <!-- <script src="{{ asset('merchant_assets/stripe.js') }}"></script> -->
        @php
            $config_keys = json_decode(get_merchant_keys($order->brand_name, $order->merchant_id));
        @endphp
        <script>
            var sale_amount = "{{ $order->sale_amount }}";
            var order_id = "{{ $order->id }}";
            var access_token = "{{ $config_keys->access_token }}";
            var csrf_token = "{{ csrf_token() }}";
            var square_route = "{{ route('square.checkout') }}";

            const appId = "{{ $config_keys->app_id }}";
            const locationId = "{{ $config_keys->location_id }}";

            async function initializeCard(payments) {
                const card = await payments.card();
                await card.attach('#card-container');

                return card;
            }

            async function createPayment(token) {
                const body = JSON.stringify({
                    locationId,
                    sourceId: token,
                    access_token: access_token,
                    order_id: order_id,
                    '_token': csrf_token,
                    amount: sale_amount
                });

                const paymentResponse = await fetch(square_route, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body,
                });

                if (paymentResponse.ok) {
                    return paymentResponse.json();
                }

                const errorBody = await paymentResponse.text();
                throw new Error(errorBody);
            }

            async function tokenize(paymentMethod) {
                const tokenResult = await paymentMethod.tokenize();
                if (tokenResult.status === 'OK') {
                    return tokenResult.token;
                } else {
                    let errorMessage = `Tokenization failed with status: ${tokenResult.status}`;
                    if (tokenResult.errors) {
                        errorMessage += ` and errors: ${JSON.stringify(
              tokenResult.errors
            )}`;
                    }

                    throw new Error(errorMessage);
                }
            }

            // status is either SUCCESS or FAILURE;
            function displayPaymentResults(status) {
                const statusContainer = document.getElementById(
                    'payment-status-container'
                );
                if (status === 'SUCCESS') {
                    statusContainer.classList.remove('is-failure');
                    statusContainer.classList.add('is-success');
                } else {
                    statusContainer.classList.remove('is-success');
                    statusContainer.classList.add('is-failure');
                }

                statusContainer.style.visibility = 'visible';
            }

            document.addEventListener('DOMContentLoaded', async function() {
                if (!window.Square) {
                    throw new Error('Square.js failed to load properly');
                }

                let payments;
                try {
                    payments = window.Square.payments(appId, locationId);
                } catch {
                    const statusContainer = document.getElementById(
                        'payment-status-container'
                    );
                    statusContainer.className = 'missing-credentials';
                    statusContainer.style.visibility = 'visible';
                    return;
                }

                let card;
                try {
                    card = await initializeCard(payments);
                } catch (e) {
                    console.error('Initializing Card failed', e);
                    return;
                }

                // Checkpoint 2.
                async function handlePaymentMethodSubmission(event, paymentMethod) {
                    event.preventDefault();

                    try {
                        // disable the submit button as we await tokenization and make a payment request.
                        cardButton.disabled = true;
                        const token = await tokenize(paymentMethod);
                        const paymentResults = await createPayment(token);
                        console.log(paymentResults);
                        displayPaymentResults('SUCCESS');
                        $('#payment_method').val('square')
                        $('#payment_id').val(paymentResults.payment.id)
                        $('#payer_id').val(paymentResults.payment.card_details.card.bin)
                        $('#paid_amount').val(paymentResults.payment.approved_money.amount)
                        $('#last_digit').val(paymentResults.payment.card_details.card.last_4)
                        $('#response').val(JSON.stringify(paymentResults.payment))
                        $('#form').submit()
                        //toastr.success('Payment has been processed successfully..!');

                    } catch (e) {
                        cardButton.disabled = false;
                        displayPaymentResults('FAILURE');
                        console.error(e.message);
                    }
                }

                const cardButton = document.getElementById('card-button');
                cardButton.addEventListener('click', async function(event) {
                    await handlePaymentMethodSubmission(event, card);
                });
            });
        </script>
    @elseif($order->merchant_id == 4)
        @php
            $config_keys = json_decode(get_merchant_keys($order->brand_name, $order->merchant_id));
        @endphp
        <script>
            $(document).on('click', '#pay-authorize', function() {
                let owner = $('#owner').val();

                if (owner == '') {
                    $('#owner-error').show();
                } else {
                    $('#owner-error').hide();
                }
                let cvv = $('#cvv').val();

                if (cvv == '') {
                    $('#cvv-error').show();
                } else {
                    $('#cvv-error').hide();
                }

                let cardNumber = $('#cardNumber').val();

                if (cardNumber == '') {
                    $('#card-error').show();
                } else {
                    $('#card-error').hide();
                }
                let amount = $('#sale_amount').val();
                let expiration_month = $('#expiration-month').val();
                let expiration_year = $('#expiration-year').val();
                let login_id = "{{ $config_keys->merchant_login_id }}";
                let transaction_key = "{{ $config_keys->merchant_transaction_key }}"
                let bool = (owner != '' && cvv != '' && cardNumber != '')

                if (bool) {
                    $.ajax({
                        url: "{{ route('authorizenet.checkout') }}",
                        type: "POST",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            owner: owner,
                            cvv: cvv,
                            cardNumber: cardNumber,
                            expiration_month: expiration_month,
                            expiration_year: expiration_year,
                            amount: amount,
                            login_id: login_id,
                            transaction_key: transaction_key
                        },
                        success: function(res) {

                            //toastr.success('Payment has been processed successfully..!');

                            $('#error-msg').hide();
                            $('#success-msg').html(res.msg)
                            $('#success-msg').show();

                            $('#payment_method').val('authorize.net')
                            $('#payment_id').val(res.data.transaction_id)
                            $('#payer_id').val(res.data.auth_id)
                            $('#paid_amount').val(res.data.amount)
                            $('#last_digit').val('')
                            $('#response').val(JSON.stringify(res.data.response))
                            $('#form').submit()

                        },
                        error: function(err) {
                            $('#success-msg').hide();
                            $('#error-msg').html(err.responseJSON.msg)
                            $('#error-msg').show();


                        }
                    })
                }


            })

            let ccNumberInput = document.querySelector('#cardNumber'),
                ccNumberPattern = /^\d{0,16}$/g,
                ccNumberSeparator = " ",
                ccNumberInputOldValue,
                ccNumberInputOldCursor,

                ccExpiryInput = document.querySelector('.cc-expiry-input'),
                ccExpiryPattern = /^\d{0,4}$/g,
                ccExpirySeparator = "/",
                ccExpiryInputOldValue,
                ccExpiryInputOldCursor,

                ccCVCInput = document.querySelector('#cvv'),
                ccCVCPattern = /^\d{0,3}$/g,

                mask = (value, limit, separator) => {
                    var output = [];
                    for (let i = 0; i < value.length; i++) {
                        if (i !== 0 && i % limit === 0) {
                            output.push(separator);
                        }

                        output.push(value[i]);
                    }

                    return output.join("");
                },
                unmask = (value) => value.replace(/[^\d]/g, ''),
                checkSeparator = (position, interval) => Math.floor(position / (interval + 1)),
                ccNumberInputKeyDownHandler = (e) => {
                    let el = e.target;
                    ccNumberInputOldValue = el.value;
                    ccNumberInputOldCursor = el.selectionEnd;
                },
                ccNumberInputInputHandler = (e) => {
                    let el = e.target,
                        newValue = unmask(el.value),
                        newCursorPosition;

                    if (newValue.match(ccNumberPattern)) {
                        newValue = mask(newValue, 4, ccNumberSeparator);

                        newCursorPosition =
                            ccNumberInputOldCursor - checkSeparator(ccNumberInputOldCursor, 4) +
                            checkSeparator(ccNumberInputOldCursor + (newValue.length - ccNumberInputOldValue.length), 4) +
                            (unmask(newValue).length - unmask(ccNumberInputOldValue).length);

                        el.value = (newValue !== "") ? newValue : "";
                    } else {
                        el.value = ccNumberInputOldValue;
                        newCursorPosition = ccNumberInputOldCursor;
                    }

                    el.setSelectionRange(newCursorPosition, newCursorPosition);

                    highlightCC(el.value);
                },
                highlightCC = (ccValue) => {
                    let ccCardType = '',
                        ccCardTypePatterns = {
                            amex: /^3/,
                            visa: /^4/,
                            mastercard: /^5/,
                            disc: /^6/,

                            genric: /(^1|^2|^7|^8|^9|^0)/,
                        };

                    for (const cardType in ccCardTypePatterns) {
                        if (ccCardTypePatterns[cardType].test(ccValue)) {
                            ccCardType = cardType;
                            break;
                        }
                    }

                    let activeCC = document.querySelector('.cc-types__img--active'),
                        newActiveCC = document.querySelector(`.cc-types__img--${ccCardType}`);

                    if (activeCC) activeCC.classList.remove('cc-types__img--active');
                    if (newActiveCC) newActiveCC.classList.add('cc-types__img--active');
                },
                ccExpiryInputKeyDownHandler = (e) => {
                    let el = e.target;
                    ccExpiryInputOldValue = el.value;
                    ccExpiryInputOldCursor = el.selectionEnd;
                },
                ccExpiryInputInputHandler = (e) => {
                    let el = e.target,
                        newValue = el.value;

                    newValue = unmask(newValue);
                    if (newValue.match(ccExpiryPattern)) {
                        newValue = mask(newValue, 2, ccExpirySeparator);
                        el.value = newValue;
                    } else {
                        el.value = ccExpiryInputOldValue;
                    }
                };

            ccNumberInput.addEventListener('keydown', ccNumberInputKeyDownHandler);
            ccNumberInput.addEventListener('input', ccNumberInputInputHandler);

            ccExpiryInput.addEventListener('keydown', ccExpiryInputKeyDownHandler);
            ccExpiryInput.addEventListener('input', ccExpiryInputInputHandler);
        </script>
    @endif
    <!-- <script src="{{ asset('merchant_assets/square.js') }}"></script>     -->
    {{--
<script>
          // var stripe = Stripe('pk_test_51LJXJiHu8oVB4xqL0tsiGVqyTIVUuuXrQfAwPDHBHmLrePhUB8nlGdFxQESn5GX5zYH9q43GdKAfDdemvnnAdwLW006tuRJezd');    
    // let url = window.location.href;
    // Call your backend to create the Checkout Session
// document.addEventListener("click", function(){
//     fetch("{{ route('stripe.checkout') }}", {
//         method: 'POST',
//         headers: {
//             "X-CSRF-Token": "{{csrf_token()}}", // 👈👈👈 Set the token
//             "Content-Type": "application/json"
//         },
//         body: JSON.stringify({
//                     url: window.location.href,
//                 })
//        // body: JSON.stringify({url:url})
//     })
//     .then(function(response) {
//     return response.json();
//     })
//     .then(function(session) {
        
//         return stripe.redirectToCheckout({ sessionId: session.session.id });
//     })
//     .then(function(result) {
//         console.log(result)
//     // If `redirectToCheckout` fails due to a browser or network
//     // error, you should display the localized error message to your
//     // customer using `error.message`.
//     if (result.error) {
//         alert(result.error.message);
//     }else{

//     }
//     });
// });

    

</script>
--}}

    <script>
        {{--
//   var stripe_key = ""; //$config_keys->stripe_key
//   function pay(){
//       var amount = $('#sale_amount').val(); 
//         var handler = StripeCheckout.configure({
//         key:stripe_key, // your publisher key id
//         locale: 'us',
//         token: function (token) {
//         // You can access the token ID with `token.id`.
//         // Get the token ID to your server-side code for use.
//         $('#payment_method').val('stripe')
//         $('#payment_id').val(token.id)
//         $('#payer_id').val(token.card.id)
//         $('#paid_amount').val(amount)
//         $('#last_digit').val(token.card.last4)
//         $('#form').submit() 
//         //$('#token_response').html(JSON.stringify(token));  
//         }
//         });
//         handler.open({
//         name: 'Payment Terminal',
//         description: 'Pay with Stripe',
//         amount: amount
//         });
//   }
--}}
        $(document).on('keyup paste', '.validate', function() {
            let bool = true;
            values = Array.from(document.querySelectorAll('.validate'))
                .map(input => input.value)
            for (var i = 0; i < values.length; i++) {
                if (values[i] == "") {
                    bool = false;
                    break;
                }
            }
            console.log(bool)
            if (bool) {
                $('#payment-methods').show();
                $('.pay-message').css('color', 'darkgrey');
            } else {
                $('#payment-methods').hide();
                $('.pay-message').css('color', 'red');

            }

        })

        $(document).ready(function($) {
            $(".card-cvc").mask("999");
            $(".card-number").mask("9999 9999 9999 9999");
            $("#phonenumber").mask("+999999999999");
        });


        ;
        (function(window, $) {
            "use strict";

            var defaultConfig = {
                type: '',
                autoDismiss: false,
                container: '#toasts',
                autoDismissDelay: 4000,
                transitionDuration: 500
            };

            $.toast = function(config) {
                var size = arguments.length;
                var isString = typeof(config) === 'string';

                if (isString && size === 1) {
                    config = {
                        message: config
                    };
                }

                if (isString && size === 2) {
                    config = {
                        message: arguments[1],
                        type: arguments[0]
                    };
                }

                return new toast(config);
            };

            var toast = function(config) {
                config = $.extend({}, defaultConfig, config);
                // show "x" or not
                var close = config.autoDismiss ? '' : '&times;';

                // toast template
                var toast = $([
                    '<div class="toast ' + config.type + '">',
                    '<p>' + config.message + '</p>',
                    '<div class="close">' + close + '</div>',
                    '</div>'
                ].join(''));

                // handle dismiss
                toast.find('.close').on('click', function() {
                    var toast = $(this).parent();

                    toast.addClass('hide');

                    setTimeout(function() {
                        toast.remove();
                    }, config.transitionDuration);
                });

                // append toast to toasts container
                $(config.container).append(toast);

                // transition in
                setTimeout(function() {
                    toast.addClass('show');
                }, config.transitionDuration);

                // if auto-dismiss, start counting
                if (config.autoDismiss) {
                    setTimeout(function() {
                        toast.find('.close').click();
                    }, config.autoDismissDelay);
                }

                return this;
            };

        })(window, jQuery);

        /* ---- start demo code ---- */

        var count = 1;
        var types = ['default', 'error', 'warning', 'info'];

        $('button').click(function() {
            var data = this.dataset;

            switch (data.type) {
                case 'types':
                    $.toast(data.kind, 'This is a ' + data.kind + ' toast.');
                    break;
                case 'html':
                    $.toast(
                        '<div class="custom-toast"><img src="https://dysfunc.github.io/animat.io/images/ron_burgundy.png"><p>You stay classy San Deigo</p></div>'
                        );
                    break;

                case 'auto':
                    $.toast({
                        autoDismiss: true,
                        message: 'This is my auto-dismiss toast message'
                    });

                    break;

                default:
                    // $.toast('Error');
            }
        });


        /* ---- end demo code ---- */
    </script>

    @if (old('card_holder_name') != '' &&
            old('card_number') != '' &&
            old('cvv_number') != '' &&
            old('exp_month') != '' &&
            old('exp_year') != '')
        <script>
            $(document).ready(function() {
                $('#payment-methods').show();
            })
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            $.toast("{{ Session::get('error') }}");
        </script>
    @endif


</body>

</html>
