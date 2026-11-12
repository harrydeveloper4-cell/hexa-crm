@extends('payment_terminals.layout.app')
@section('title', 'Authorize')

@section('css')
@endsection

@section('content')
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
            <input type="text" class="form-control" id="owner" name="owner" value="{{ old('owner') }}" required>
            <span id="owner-error" class="error text-red">Please enter owner
                name</span>
        </div>
        <div class="form-group CVV col-md-4">
            <label for="cvv">CVV</label>
            <input type="text" class="form-control" id="cvv" name="cvv" value="{{ old('cvv') }}" required>
            <span id="cvv-error" class="error text-red">Please enter cvv</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-8" id="card-number-field">
            <label for="cardNumber">Card Number</label>
            <input type="text" class="form-control" id="cardNumber" name="cardNumber" value="{{ old('cardNumber') }}"
                required>
            <span id="show-cc-label"></span>
            <span id="card-error" class="error text-red">Please enter valid card
                number</span>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6" id="expiration-date">
            <label>Expiration Date</label><br />
            <select class="form-control" id="expiration-month" name="expiration-month"
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
            <select class="form-control" id="expiration-year" name="expiration-year" style="float: left; width: 100px;">

                @for ($i = date('Y'); $i <= date('Y') + 15; $i++)
                    <option value="{{ $i }}">{{ $i }}
                    </option>
                @endfor
            </select>
        </div>
        <div class="form-group col-md-6" id="credit_cards" style="margin-top: 22px;">
            <img src="{{ asset('images/visa.png') }}" id="visa">
            <img src="{{ asset('images/mastercard.png') }}" id="mastercard">
            <img src="{{ asset('images/amex.jpg') }}" id="amex" width = "40" height = "25">
        </div>
    </div>

    <br />
    <div class="form-group" id="pay-now">
        <button type="button" class="btn btn-success themeButton" id="pay-authorize">Pay with Authorize.net</button>
    </div>
@endsection

@section('scripts')
    @php
        $config_keys = json_decode(get_merchant_keys($order->brand_name, $order->merchant_id));
    @endphp
    <script>
        $(document).on('click', '#pay-authorize', function() {
            $("#pay-authorize").prop("disabled" , true)
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

                        console.log(res);
                        if(res.data.payment_status == "success"){
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
                        }
                        //toastr.success('Payment has been processed successfully..!');

                       

                    },
                    error: function(err) {
                        $('#success-msg').hide();
                        $('#error-msg').html(err.responseJSON.msg)
                        $('#error-msg').show();
                        $("#pay-authorize").prop("disabled" , false)

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
@endsection
