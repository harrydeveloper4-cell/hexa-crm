@extends('payment_terminals.layout.app')
@section('title', 'Square')

@section('css')
@endsection

@section('content')
    <form id="payment-form">
        <div id="card-container"></div>
        <p class="textmuted h8 mb-2 pay-message text-danger" id="paymentResultsError"></p>
        <button id="card-button" class = "btn btn-primary d-block h8" type="button">PAY <span
                class="fas fa-dollar-sign ms-2"></span>{{ number_format($order->sale_amount, 2) }}<span
                class="ms-3 fas fa-arrow-right"></span></button>
    </form>
    <div id="payment-status-container"></div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    @if (env('SQUAREUP_ENVIRONMENT') == 'sandbox')
        <script type="text/javascript" src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
    @elseif(env('SquareUP_ENVIRONMENT') == 'production')
        <script type="text/javascript" src="https://web.squarecdn.com/v1/square.js"></script>
    @endif
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

        // let idempotencyKey = `${order_id}-${Date.now()}-${Math.random()}`; // Initial key
        // console.log(idempotencyKey);
        

        async function createPayment(token) {
            const body = JSON.stringify({
                locationId,
                sourceId: token,
                access_token: access_token,
                order_id: order_id,
                '_token': csrf_token,
                amount: sale_amount,
                // idempotency_key: idempotencyKey, // Ensure unique key
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

            const errorBody = await paymentResponse.json(); // Parse error response as JSON
            // Create a custom error object
            const error = new Error(errorBody.error || "Payment failed.");
            error.errors = errorBody.errors || [];
            errors = errorBody.errors || [];
            errors.forEach((error) => {
                switch (error.code) {
                    case 'CVV_FAILURE':
                        toastr.error("The CVV number is incorrect. Please try again.");
                        $('#paymentResultsError').text("The CVV number is incorrect. Please try again.");
                        break;
                    case 'CARD_DECLINED_VERIFICATION_REQUIRED':
                        toastr.error("Card declined verification required. Please try again.");
                        $('#paymentResultsError').text("Card declined verification required. Please try again.");
                        break;
                    case 'GENERIC_DECLINE':
                        toastr.error("The card was declined. Please try again.");
                        $('#paymentResultsError').text("The card was declined. Please try again.");
                        break;
                    case 'INVALID_EXPIRATION':
                        toastr.error("The expiration date is incorrect. Please try again.");
                        $('#paymentResultsError').text("The expiration date is incorrect. Please try again.");
                        break;
                    case 'CARD_DECLINED':
                        toastr.error("Your card was declined. Please use another card.");
                        $('#paymentResultsError').text("Your card was declined. Please use another card.");
                        break;
                    case 'INSUFFICIENT_FUNDS':
                        toastr.error("Insufficient funds on the card. Please try another payment method.");
                        $('#paymentResultsError').text("Insufficient funds on the card. Please try another payment method.");
                        break;
                    case 'IDEMPOTENCY_KEY_REUSED':
                        toastr.error("This payment request has already been processed. Please refresh and try again.");
                        $('#paymentResultsError').text("This payment request has already been processed. Please refresh and try again.");
                        break;
                    default:
                        toastr.error(`Payment failed: ${error.detail || "An unknown error occurred."}`);
                        $('#paymentResultsError').text(`Payment failed: ${error.detail || "An unknown error occurred."}`);
                        break;
                }
            });
            throw error;

            // const errorBody = await paymentResponse.text();
            // throw new Error(errorBody);
        }

        /**
         * Tokenize the payment method.
         */

        async function tokenize(paymentMethod) {
            const tokenResult = await paymentMethod.tokenize();
            console.log('Tokenization result:', tokenResult);

            // if (tokenResult.status === 'OK') {
            //     return tokenResult.token;
            // } else {
            //     let errorMessage = `Tokenization failed with status: ${tokenResult.status}`;
            //     if (tokenResult.errors) {
            //         errorMessage += ` and errors: ${JSON.stringify(
            //             tokenResult.errors
            //         )}`;
            //     }

            //     throw new Error(errorMessage);
            // }

            if (tokenResult.status === 'OK') {
                return tokenResult.token;
            }

            if (tokenResult.errors && tokenResult.errors.length > 0) {
                const firstError = tokenResult.errors[0]; 
                // toastr.error(firstError.message);
                $('#paymentResultsError').text(firstError.message);
                throw new Error(`Tokenization failed for ${firstError.field}: ${firstError.message}`);
            } else {
                throw new Error(`Tokenization failed with status: ${tokenResult.status}`);
            }

            // const error = new Error(`Tokenization failed with status: ${tokenResult.status}`); 

            // if (tokenResult.errors) {
            //     error.message += ` and errors: ${JSON.stringify(tokenResult.errors)}`;
            // }

            // throw error;
        }

        /**
         * Display the payment status visually on the UI.
         */
        function displayPaymentResults(status) {
            const statusContainer = document.getElementById('payment-status-container');
            statusContainer.classList.toggle('is-success', status === 'SUCCESS');
            statusContainer.classList.toggle('is-failure', status !== 'SUCCESS');
            statusContainer.style.visibility = 'visible';
        }

        document.addEventListener('DOMContentLoaded', async function() {
            if (!window.Square) {
                throw new Error('Square.js failed to load properly');
            }

            let payments;
            try {
                payments = window.Square.payments(appId, locationId);
                console.log('Square payments initialized:', payments);
            } catch (error) {
                console.error('Error initializing Square payments:', error);
                document.getElementById('payment-status-container').className = 'missing-credentials';
                return;
            }

            let card;
            try {
                card = await initializeCard(payments);
            } catch (error) {
                console.error('Error initializing card:', error);
                return;
            }

            // Checkpoint 2.
            async function handlePaymentMethodSubmission(event, paymentMethod) {
                event.preventDefault();
                cardButton.disabled = true;

                try {
                    // disable the submit button as we await tokenization and make a payment request.
                    const token = await tokenize(paymentMethod);
                    const paymentResults = await createPayment(token);
                    
                    console.log(paymentResults);
                    console.log(Array.isArray(paymentResults));
                    console.log('paymentResults');

                    // Handle successful payment
                    if (!Array.isArray(paymentResults)) {
                        displayPaymentResults('SUCCESS');
                        $('#payment_method').val('square');
                        $('#payment_id').val(paymentResults.payment.id);
                        $('#payer_id').val(paymentResults.payment.card_details.card.bin);
                        $('#paid_amount').val(paymentResults.payment.approved_money.amount);
                        $('#last_digit').val(paymentResults.payment.card_details.card.last_4);
                        $('#response').val(JSON.stringify(paymentResults.payment));
                        $('#form').submit();
                        return;
                    }
                    // Handle errors if the response contains an array of errors
                    displayPaymentResults('FAILURE');
                    paymentResults.forEach((error) => {
                        switch (error.code) {
                            case 'CVV_FAILURE':
                                toastr.error("The CVV number is incorrect. Please try again.");
                                $('#paymentResultsError').text("The CVV number is incorrect. Please try again.");
                                break;
                            case 'CARD_DECLINED_VERIFICATION_REQUIRED':
                                toastr.error("Card declined verification required. Please try again.");
                                $('#paymentResultsError').text("Card declined verification required. Please try again.");
                                break;
                            case 'GENERIC_DECLINE':
                                toastr.error("The card was declined. Please try again.");
                                $('#paymentResultsError').text("The card was declined. Please try again.");
                                break;
                            case 'INVALID_EXPIRATION':
                                toastr.error("The expiration date is incorrect. Please try again.");
                                $('#paymentResultsError').text("The expiration date is incorrect. Please try again.");
                                break;
                            case 'CARD_DECLINED':
                                toastr.error("Your card was declined. Please use another card.");
                                $('#paymentResultsError').text("Your card was declined. Please use another card.");
                                break;
                            case 'INSUFFICIENT_FUNDS':
                                toastr.error("Insufficient funds on the card. Please try another payment method.");
                                $('#paymentResultsError').text("Insufficient funds on the card. Please try another payment method.");
                                break;
                            case 'IDEMPOTENCY_KEY_REUSED':
                                toastr.error("This payment request has already been processed. Please refresh and try again.");
                                $('#paymentResultsError').text("This payment request has already been processed. Please refresh and try again.");
                                break;
                            default:
                                toastr.error(`Payment failed: ${error.detail || "An unknown error occurred."}`);
                                $('#paymentResultsError').text(`Payment failed: ${error.detail || "An unknown error occurred."}`);
                                break;
                        }
                    });

                    //toastr.success('Payment has been processed successfully..!');
                } catch (error) {
                    console.error('Payment handling error:', error);
                    toastr.error(error.message || "An unexpected error occurred.");
                    $('#paymentResultsError').text(error.message || "An unexpected error occurred.");
                } finally {
                    cardButton.disabled = false;
                }
            }

            const cardButton = document.getElementById('card-button');
            cardButton.addEventListener('click', async function (event) {
                await handlePaymentMethodSubmission(event, card);
            });
        });
    </script>
@endsection
