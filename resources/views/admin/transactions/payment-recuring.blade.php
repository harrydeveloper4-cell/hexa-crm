@extends('admin.layout.master')
@section('title', 'Payment Recurring')

@section('css')
    <style>
        .spin {
            width: 25px;
            display: none;
        }
    </style>
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Payment Recurring') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Payment Recurring') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">
                    <h4 class="card-title">
                        <select class = "form-control" name = "customer" id = "customer">
                            <option value = "">Select Customer</option>
                            @foreach ($customers as $customer)
                                <option value = "{{ $customer->email }}">
                                    {{ $customer->firstname . ' ' . $customer->lastname . ' (' . $customer->email . ')' }}
                                </option>
                            @endforeach
                        </select>
                    </h4>
                    {{-- <span class = "float-right">
                        <select class = "form-control" id = "update-status">
                            <option value = "">Update Status</option>
                            <option value = "Pending">Pending</option>
                            <option value = "Delivered">Delivered</option>
                        </select>
                    </span> --}}

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display table dataTable table-striped table-bTransactioned">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Order Number</th>
                                    <th>Sales Amount</th>
                                    <th>Payment Method</th>
                                    <th>Transaction Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id = "response">
                            </tbody>
                            <tfoot>
                                <th>ID</th>
                                <th>Order Number</th>
                                <th>Sales Amount</th>
                                <th>Payment Method</th>
                                <th>Transaction Date</th>
                                <th>Action</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Recharge Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action = "{{ route('payment_recharge') }}" method = "POST" id = "form">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="hidden" name = "payment_method" id="payment_method" value = "">
                                <input type="hidden" name = "payment_id" id="payment_id" value = "">
                                <input type="hidden" name = "payer_id" id="payer_id" value = "">
                                <input type="hidden" name = "paid_amount" id="paid_amount" value = "">
                                <input type="hidden" name = "last_digit" id="last_digit" value = "">
                                <input type="hidden" name = "response" id="response" value = "">
                                <input type="hidden" name = "order_id" id="order_id" value = "">
                                <input type="hidden" name = "brand" id="brand" value = "">
                                <input type="hidden" name = "email" id="email" value = "">
                                <input type="hidden" name = "merchant" id="merchant" value = "">
                                <label for="inputEmail4">Order#</label>
                                <input type="text" class="form-control" id="ordernumber" value = "" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Amount</label>
                                <input type="number" class="form-control" name = "sale_amount" id="sale_amount"
                                    value = "" >
                                <input type="hidden" name = "sale_currency" id="sale_currency" value = "">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Owner</label>
                                <input type="text" class="form-control" id="owner" value = "" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Card Number</label>
                                <input type="text" class="form-control" id="card4" value = "" readonly>
                                <input type="hidden" id="cardNumber" value = "">
                                <input type="hidden" id="cvv" value = "">
                                <input type="hidden" id="expiration-month" value = "">
                                <input type="hidden" id="expiration-year" value = "">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="inputEmail4">Description</label>
                                <textarea name = "description" class="form-control" id="description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        $(document).ready(function() {
            $(document).on('change', '#customer', function() {
                let email = $(this).val();

                if (email != '') {
                    $.ajax({
                        url: "{{ route('customer.transactions') }}",
                        type: 'POST',
                        data: {
                            email: email,
                            '_token': "{{ csrf_token() }}"
                        },
                        beforeSend: function() {
                            $(".se-pre-con").show();
                        },
                        success: function(data) {
                            $('#response').html(data.records);
                            $(".se-pre-con").hide();
                        }
                    })
                } else {
                    $('#response').html(
                        '<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No data available in table</td></tr>'
                    )
                }
            })

            $(document).on('click', '.payment-reoccur', function() {
                let elem = $(this);
                $.ajax({
                    url: "{{ route('customer.card.details') }}",
                    type: "POST",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        email: elem.data('email'),
                        merchant: elem.data('merchant')
                    },
                    beforeSend: function() {
                        $(".se-pre-con").show();
                    },
                    success: function(res) {
                        $('#ordernumber').val(elem.data('ordernumber'))
                        $('#order_id').val(elem.data('order'))
                        $('#brand').val(elem.data('brand'))
                        $('#email').val(elem.data('email'))
                        $('#merchant').val(elem.data('merchant'))
                        $('#sale_currency').val(elem.data('currency'))
                        $('#owner').val(res.owner)
                        $('#card4').val('xxxx xxxx xxxx ' + res.last4)
                        $('#cardNumber').val(res.cardNumber)
                        $('#cvv').val(res.cvv)
                        $('#expiration-month').val(res.expiration_month)
                        $('#expiration-year').val(res.expiration_year)
                        if (elem.data('merchant') == 'authorize.net') {
                            $('.modal-footer').html(
                                '<button type="button" class="btn btn-primary" id = "pay-authorize">Pay with Authorize.net </button> <img style class = "spin" src = "{{ asset('images/spin.gif') }}">'
                            )
                        } else if (elem.data('merchant') == 'stripe') {
                            $('.modal-footer').html(
                                '<button type="button" class="btn btn-primary" id = "stripe-pay" >Pay with Stripe </button> <img style class = "spin" src = "{{ asset('images/spin.gif') }}">'
                            )
                        }
                        $(".se-pre-con").hide();
                    }
                })
            })
            $(document).on('click', '#stripe-pay', function() {
                $('#stripe-pay').attr('disabled', true)
                $.ajax({
                    url: "{{ route('merchant.configs') }}",
                    type: "GET",
                    data: {
                        order_id: $('#order_id').val()
                    },
                    beforeSend: function() {
                        $(".spin").show();
                    },
                    success: function(res_config) {
                        let stripe_key = res_config.stripe_key;
                        let secret_key = res_config.stripe_secret_key;

                        Stripe.setPublishableKey(stripe_key);

                        Stripe.createToken({

                            number: $('#cardNumber').val(),

                            cvc: $('#cvv').val(),

                            exp_month: $('#expiration-month').val(),

                            exp_year: $('#expiration-year').val()

                        }, stripeResponseHandler);

                        function stripeResponseHandler(status, response) {

                            if (response.error) {

                                $('.error')

                                    .removeClass('hide')

                                    .find('.alert')

                                    .text(response.error.message);

                                //  $body.removeClass("loading");

                                alert(response.error.message)
                                toastr.error(response.error.message);
                                //generateNotification(0,response.error.message);

                                return false;

                            } else {

                                // token contains id, last4, and card type
                                //console.log(response)
                                let token = response['id'];
                                let amount = $('#sale_amount').val();
                                let sale_currency = $('#sale_currency').val();
                                let brand_name = $('#description').val();
                                $.ajax({
                                    url: "{{ route('stripe.checkout') }}",
                                    type: "POST",
                                    data: {
                                        '_token': "{{ csrf_token() }}",
                                        amount: amount,
                                        sale_currency: sale_currency,
                                        stripeToken: token,
                                        brand_name: brand_name,
                                        secret_key: secret_key
                                    },
                                    success: function(res) {
                                        $('#payment_method').val('stripe')
                                        $('#payment_id').val(res.payment_id)
                                        $('#payer_id').val(res.payer_id)
                                        $('#paid_amount').val(res.paid_amount)
                                        $('#last_digit').val(res.last4)
                                        $('#response').val(JSON.stringify(res
                                            .response))
                                        $('#form').submit()
                                        toastr.success(
                                            'Payment has been processed successfully..!'
                                        );
                                        $(".spin").hide();
                                        $('#stripe-pay').attr('disabled', false)
                                    },
                                    error: function(err) {
                                        console.log(err.responseJSON.msg);
                                        toastr.error(err.responseJSON.msg);
                                        $(".spin").hide();
                                        $('#stripe-pay').attr('disabled', false)
                                        const errorMessage = $(`<label class="error-message text-danger">${err.responseJSON.msg}*</label>`);
                                        $('#sale_amount').after(errorMessage);
                                    }
                                })


                            }

                        }

                    }
                })

            })

            $(document).on('click', '#pay-authorize', function() {
                $('#pay-authorize').attr('disabled', true)
                $.ajax({
                    url: "{{ route('merchant.configs') }}",
                    type: "GET",
                    data: {
                        order_id: $('#order_id').val()
                    },
                    beforeSend: function() {
                        $(".spin").show();
                    },
                    success: function(res_config) {


                        let owner = $('#owner').val();
                        let cvv = $('#cvv').val();
                        let cardNumber = $('#cardNumber').val();
                        let amount = $('#sale_amount').val();
                        let expiration_month = $('#expiration-month').val();
                        let expiration_year = $('#expiration-year').val();
                        let login_id = res_config.merchant_login_id;
                        let transaction_key = res_config.merchant_transaction_key;
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
                                    toastr.success(
                                        'Payment has been processed successfully..!'
                                    );
                                    $('#payment_method').val('authorize.net')
                                    $('#payment_id').val(res.data.transaction_id)
                                    $('#payer_id').val(res.data.auth_id)
                                    $('#paid_amount').val(res.data.amount)
                                    $('#last_digit').val('')
                                    $('#response').val(JSON.stringify(res.data
                                        .response))
                                    $('#form').submit()
                                    $('#pay-authorize').attr('disabled', false)
                                    $(".spin").hide();
                                },
                                error: function(err) {
                                    toastr.error(err.responseJSON.msg);
                                    $('#pay-authorize').attr('disabled', false)
                                    $(".spin").hide();
                                }
                            })
                        }
                    }
                })
            })
        })
    </script>
@endsection
