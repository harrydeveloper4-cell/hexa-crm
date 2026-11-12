<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderPaymentTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Square\SquareClient;
use Square\LocationsApi;
use Square\Exceptions\ApiException;
use Square\Http\ApiResponse;
use Square\Models\ListLocationsResponse;
use Square\Environment;
use Square\Models\Money;
use Square\Models\CreatePaymentRequest;
use Square\Models\createPayment;

class SquareController extends Controller
{
  public function squarePayment(Request $request)
  {
    try {
      $data = $request->all();
      $orderID = $data['order_id'];
      $idempotencyKey = uniqid();

      $order = Order::find($orderID);
      if ($order->payment_status == 'paid') {
          return response()->json([
              'error' => 'This transaction has already been processed.'
          ], 400);
      }
      if (Carbon::parse($order->expires_at)->toDateString() < now()->toDateString()) {
            return response()->view('errors.500', ['message' => 'The order has expired.', 'order' => $order], 500);
        }
    //   if ($order->expires_at < now()) {
    //       return response()->json([
    //           'error' => 'The order has expired.'
    //       ], 400);
    //   }

      $square_client = new SquareClient([
        'accessToken' => $data['access_token'],
        'environment' => Environment::SANDBOX,
      ]);
      $payments_api = $square_client->getPaymentsApi();
      $money = new Money();
      $money->setAmount($data['amount']);
      // Set currency to the currency for the location
      //$money->setCurrency($location_info->getCurrency());
      $money->setCurrency('USD');
      // Every payment you process with the SDK must have a unique idempotency key.
      // If you're unsure whether a particular payment succeeded, you can reattempt
      // it with the same idempotency key without worrying about double charging
      // the buyer.

      
      // $order_id = $data['order_id'];
      $create_payment_request = new CreatePaymentRequest($data['sourceId'], $idempotencyKey, $money);
      $response = $payments_api->createPayment($create_payment_request);
      if ($response->isSuccess()) {
            $payment = $response->getResult()->getPayment();
            $status = $payment->getStatus();
            // If the payment is successful, update the payment status and generate the PDF
            if ($status === 'COMPLETED') {
                return response()->json($response->getResult(), 200); // Return success
            } else {
                Log::error("Payment not completed for order number: " . $orderID);
                
                return response()->json([
                    'error' => 'Payment failed.',
                    'errors' => 'Payment not completed',
                ], 400); // Return Square API errors
            }
        //   return response()->json($response->getResult(), 200); // Return success
      } else {
          $errors = $response->getErrors();
          return response()->json([
              'error' => 'Payment failed.',
              'errors' => $errors,
          ], 400); // Return Square API errors
      }
    } catch (\Throwable $th) {
        // Handle unexpected server-side errors
        return response()->json([
            'error' => 'An unexpected error occurred.',
            'errors' => [
                [
                    'code' => 'SERVER_ERROR',
                    'detail' => $th->getMessage(),
                ],
            ],
        ], 500);
    }
  }
}
