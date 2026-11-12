<?php

namespace App\Http\Controllers;

// use Exception;
use Illuminate\Http\Request;
use Stripe;

class StripeController extends Controller
{
  public function stripe_checkout(Request $request)
  {
    Stripe\Stripe::setApiKey($request->secret_key);
    try {
      $grand_total = $request->amount / 100;
      $charge = Stripe\Charge::create([
        "amount" =>  $request->amount * 100,
        "currency" => $request->sale_currency,
        "source" => $request->stripeToken,
        "description" => "Payment from merchant - " . $request->brand_name,
      ]);
      // Use Stripe's library to make requests...
    } catch (\Stripe\Exception\CardException $e) {
      return response()->json(['msg' => $e->getError()->message], 403);
    } catch (\Stripe\Exception\RateLimitException $e) {
      // Too many requests made to the API too quickly
      return response()->json(['msg' => $e->getError()->message], 403);
    } catch (\Stripe\Exception\InvalidRequestException $e) {
      // Invalid parameters were supplied to Stripe's API
      return response()->json(['msg' => $e->getError()->message], 403);
    } catch (\Stripe\Exception\AuthenticationException $e) {
      // Authentication with Stripe's API failed
      // (maybe you changed API keys recently)
      return response()->json(['msg' => $e->getError()->message], 403);
    } catch (\Stripe\Exception\ApiConnectionException $e) {
      // Network communication with Stripe failed
      return response()->json(['msg' => $e->getError()->message], 403);
    } catch (\Stripe\Exception\ApiErrorException $e) {
      // Display a very generic error to the user, and maybe send
      // yourself an email
      return response()->json(['msg' => $e->getError()->message], 403);
    } catch (Exception $e) {
      // Something else happened, completely unrelated to Stripe
      return response()->json(['msg' => $e->getMessage()->message], 403);
    }

    if (isset($charge) && isset($charge->id)) {
      return response()->json([
        'payment_id' => $charge->id,
        'payer_id' => $charge->balance_transaction,
        'response' => serialize($charge),
        'paid_amount' => $charge->amount_captured,
        'last4'  => $charge->payment_method_details->card->last4

      ], 200);
    }
  }
}
