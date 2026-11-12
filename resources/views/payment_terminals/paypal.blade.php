@extends('payment_terminals.layout.app')
@section('title', 'Paypal')

@section('css')
@endsection

@section('content')
    <div id = "paypal-button-container-popup"></div>
@endsection

@section('scripts')
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
@endsection
