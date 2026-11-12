@extends('payment_terminals.layout.app')

@section('title', $order->brand_details->name)
@section('desc', $order->brand_details->desc)
@section('img', asset($order->brand_details->logo))
@section('url', $order->brand_details->link)

@section('css')
@endsection

@section('content')
    <div id="card-element"></div>

    <?php
        $is_hider = 0;
        if($is_hider == 1){
        ?>

    <div class="form-row row">
        <div class="col-xs-12 form-group required"><label class="control-label">Name on Card</label> <input
                class="form-control" size="4" type="text" name="owner" /></div>
    </div>
    <div class="form-row row">
        <div class="col-xs-12 form-group card required">
            <label class="control-label">Card Number</label> <input autocomplete="off" class="form-control card-number"
                data-ng-minlength="19" maxlength="19" inputmode="numeric" placeholder="4242 4242 4242 4242"
                name="cardNumber" type="text" />
        </div>
    </div>
    <div class="form-row row">
        <div class="col-xs-12 col-md-4 form-group cvc required"><label class="control-label">CVC</label> <input
                autocomplete="off" class="form-control card-cvc" name="cvv" placeholder="ex. 311" size="4"
                type="text" /></div>

        <div class="col-xs-12 col-md-4 form-group expiration required">
            <label class="control-label">Expiration Month</label>

            <select class="form-control card-expiry-month" name="expiration-month">
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
        <input type="submit" class = "btn btn-primary d-block h8" value = "Pay with Stripe" id = "checkout-button">
    </div>
@endsection

@section('scripts')
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
@endsection
