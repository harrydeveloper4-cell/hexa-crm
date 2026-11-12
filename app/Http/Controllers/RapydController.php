<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\CardDetail;
use App\Models\Package;
use App\Models\Merchant;
use App\Models\OrderPackage;
use App\Models\OrderPaymentTransaction;
use App\Mail\OrderInvoice;
use App\Mail\PaymentLink;
use Crypt;
use Mail;
use DateTime;
use Exception;

class RapydController extends Controller
{
    public $access_key;
    public $secret_key;
    public function checkout_rapyd(Request $request)
    {
        try {
            $order = Order::find($request->order_id);
            $config_keys = json_decode(get_merchant_keys($order->brand_name, $order->merchant_id));
            $this->access_key = $config_keys->access_key;
            $this->secret_key = $config_keys->secret_key;
            $en_data = base64_encode(serialize($request->except('_token')));
            $cancel_checkout_url = url()->previous();
            //$complete_checkout_url = route('rapyd.response',['data'=>$en_data]);
            $country = "US";
            $currency = $_POST['sale_currency'];

            $name = $request->firstname . " " . $request->lastname;
            $phonenumber = $request->billing_phonenumber;
            $customer_email = $order->customer_email;
            $brand_name = $order->brand_name;

            $access_key = $this->access_key;
            $secret_key = $this->secret_key;

            $compose_data = array(
                'name' => $name,
                'phonenumber' => $phonenumber,
                'customer_email' => $customer_email,
                'brand_name' => $brand_name,
                'secret_key' => $secret_key,
                'access_key' => $access_key,
            );
            $customer_id = $this->create_customer($compose_data);
            if ($customer_id['status'] == 0) {
                session()->flash('error', $customer_id['msg']);
                return redirect()->back()
                    ->withInput($request->input());
            }

            $customer_id = $customer_id['msg'];
            $amount = (int)$_POST['sale_amount'];
            $generate_body = array(
                'order_id' => $order->id,
                'secret_key' => $secret_key,
                'access_key' => $access_key,

                'currency' => $currency,
                'amount' => $amount,

                'customer_id' => $customer_id,

                'card_number' => $request->card_number,
                'exp_month' => $request->exp_month,
                'exp_year' => $request->exp_year,
                'card_holder_name' => $request->card_holder_name,
                'cvv_number' => $request->cvv_number,

                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'billing_address' => $request->billing_address,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'postalcode' => $request->postalcode,
                'email' => $order->customer_email,
                'billing_phonenumber' => $request->billing_phonenumber,

            );
            $payment_result = $this->create_payment($generate_body);
            if ($payment_result['status'] == 0) {
                session()->flash('error', $payment_result['msg']);
                return redirect()->back()
                    ->withInput($request->input());
            } else {
                return redirect()->route('thanks', ['oi' => $order->order_number]);
                // return redirect($payment_result['msg']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    private function create_payment($data)
    {
        try {
            $secret_key = $data['secret_key'];
            $length = 12;
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $http_method = 'post';  // Lower case.
            $salt = substr(str_shuffle($permitted_chars), 0, $length);  // Randomly generated for each request.
            $date = new DateTime();
            $timestamp = $date->getTimestamp(); // Current Unix time.
            $body = [
                "amount" =>  $data['amount'],
                "currency" => $data['currency'],
                "customer" => $data['customer_id'],
                "payment_method" => array(
                    "type" => "gb_visa_card",
                    "fields" => array(
                        "number" => str_replace(" ", "", $data['card_number']),
                        "expiration_month" => $data['exp_month'],
                        "expiration_year" => $data['exp_year'],
                        "name" => $data['card_holder_name'],
                        "cvv" => $data['cvv_number']
                    ),
                    "metadata" => null,
                ),
                "capture" =>  true,
                "3DS_requirede" =>  true
            ];
            $path_maker = '/v1/payments';
            if (env('RAPYD_ENVIRONMENT') == 'sandbox') {
                $base_url = 'https://sandboxapi.rapyd.net'; //sandbox
            } elseif (env('RAPYD_ENVIRONMENT') == 'production') {
                $base_url = 'https://api.rapyd.net'; //production        
            }
            $access_key = $data['access_key'];
            $body_string = !is_null($body) ? json_encode($body, JSON_UNESCAPED_SLASHES) : '';
            $sig_string = "$http_method$path_maker$salt$timestamp$access_key$secret_key$body_string";
            $hash_sig_string = hash_hmac("sha256", $sig_string, $secret_key);
            $signature = base64_encode($hash_sig_string);

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "$base_url$path_maker",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $body_string,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    "access_key: $access_key",
                    "salt: $salt",
                    "timestamp: $timestamp",
                    "signature: $signature",
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $result = json_decode($response);
            if (isset($result->status->error_code) && $result->status->error_code != "") {
                $returner = array(
                    'status' => 0,
                    'msg' => "Error Code: " . $result->status->error_code . " , Error Message (" . $result->status->message . ")"
                );
                return $returner;
            } elseif ($result->status->status == "SUCCESS" && $result->data->status == "CLO") {
                $fetcher['firstname'] = $data['firstname'];
                $fetcher['lastname'] = $data['lastname'];
                $fetcher['billing_address'] = $data['billing_address'];
                $fetcher['country'] = $data['country'];
                $fetcher['state'] = $data['state'];
                $fetcher['city'] = $data['city'];
                $fetcher['postalcode'] = $data['postalcode'];
                $fetcher['email'] = $data['email'];
                $fetcher['billing_phonenumber'] = $data['billing_phonenumber'];

                $fetcher['owner'] = $data['card_holder_name'];
                $fetcher['cvv'] = $data['cvv_number'];
                $fetcher['cardNumber'] = $data['card_number'];
                $fetcher['expiration_month'] = $data['exp_month'];
                $fetcher['expiration_year'] = $data['exp_year'];

                $fetcher['payment_id'] = $result->data->id;
                $fetcher['payer_id'] = $result->data->customer_token;
                $fetcher['paid_amount'] = $result->data->original_amount;
                $fetcher['response'] = json_encode($result->data);

                $fetcher['role_id'] = 2;
                $fetcher['sale_currency'] = $data['currency'];
                $fetcher['sale_amount'] = $data['amount'];

                $order = Order::find($data['order_id']);

                $fetcher['order_id'] = $data['order_id'];

                if (!empty($order)) {
                    $order->payment_status = 'paid';
                    $order->payment_link = null;
                    $order->save();

                    $user_data = [];
                    $user = new User();
                    foreach ($user->getFillable() as $key) {
                        $user_data[$key] = $fetcher[$key];
                    }

                    if (!User::where('email', $fetcher['email'])->exists()) {
                        User::create($user_data);
                    } else {

                        User::where('email', $fetcher['email'])->update($user_data);
                    }

                    $pay = OrderPaymentTransaction::create($fetcher);

                    $mail_data = [
                        'order' => $order,
                        'payout' => $fetcher
                    ];

                    //Mail::to($fetcher['email'])->send(new OrderInvoice($mail_data));

                    if (isset($fetcher['cardNumber']) && isset($fetcher['cvv']) && isset($fetcher['owner']) && isset($fetcher['expiration_month']) && isset($fetcher['expiration_month'])) {
                        if (CardDetail::where('customer_email', $order->customer_email)->exists()) {
                            $card = CardDetail::where('customer_email', $order->customer_email)->first();
                            $card_details = CardDetail::find($card->id);
                            $card_details->owner = $fetcher['owner'];
                            $card_details->cardNumber = $fetcher['cardNumber'];
                            $card_details->cvv = $fetcher['cvv'];
                            $card_details->expiration_month = $fetcher['expiration_month'];
                            $card_details->expiration_year = $fetcher['expiration_year'];
                            $card_details->customer_email = $order->customer_email;
                            $card_details->merchant = 'Rapyd';
                            $card_details->save();
                        } else {
                            $card_details = new CardDetail();
                            $card_details->owner = $fetcher['owner'];
                            $card_details->cardNumber = $fetcher['cardNumber'];
                            $card_details->cvv = $fetcher['cvv'];
                            $card_details->expiration_month = $fetcher['expiration_month'];
                            $card_details->expiration_year = $fetcher['expiration_year'];
                            $card_details->customer_email = $order->customer_email;
                            $card_details->merchant = 'Rapyd';
                            $card_details->save();
                        }
                    }
                    session()->forget('page_id');
                }
            }
            // New Code
            elseif ($result->data->status == "ACT") {
                $fetcher['firstname'] = $data['firstname'];
                $fetcher['lastname'] = $data['lastname'];
                $fetcher['billing_address'] = $data['billing_address'];
                $fetcher['country'] = $data['country'];
                $fetcher['state'] = $data['state'];
                $fetcher['city'] = $data['city'];
                $fetcher['postalcode'] = $data['postalcode'];
                $fetcher['email'] = $data['email'];
                $fetcher['billing_phonenumber'] = $data['billing_phonenumber'];

                $fetcher['owner'] = $data['card_holder_name'];
                $fetcher['cvv'] = $data['cvv_number'];
                $fetcher['cardNumber'] = $data['card_number'];
                $fetcher['expiration_month'] = $data['exp_month'];
                $fetcher['expiration_year'] = $data['exp_year'];

                $fetcher['payment_id'] = $result->data->id;
                $fetcher['payer_id'] = $result->data->customer_token;
                $fetcher['paid_amount'] = $result->data->original_amount;
                $fetcher['response'] = json_encode($result->data);

                $fetcher['role_id'] = 2;
                $fetcher['sale_currency'] = $data['currency'];
                $fetcher['sale_amount'] = $data['amount'];

                $order = Order::find($data['order_id']);

                $fetcher['order_id'] = $data['order_id'];

                if (!empty($order)) {
                    $order->payment_status = '3DS In Process';
                    $order->save();

                    $user_data = [];
                    $user = new User();
                    foreach ($user->getFillable() as $key) {
                        $user_data[$key] = $fetcher[$key];
                    }

                    if (!User::where('email', $fetcher['email'])->exists()) {
                        User::create($user_data);
                    } else {

                        User::where('email', $fetcher['email'])->update($user_data);
                    }

                    $pay = OrderPaymentTransaction::create($fetcher);

                    // $mail_data = [
                    //     'order' => $order,
                    //     'payout' => $fetcher
                    // ];

                    //Mail::to($fetcher['email'])->send(new OrderInvoice($mail_data));

                    if (isset($fetcher['cardNumber']) && isset($fetcher['cvv']) && isset($fetcher['owner']) && isset($fetcher['expiration_month']) && isset($fetcher['expiration_month'])) {

                        if (CardDetail::where('customer_email', $order->customer_email)->exists()) {

                            $card = CardDetail::where('customer_email', $order->customer_email)->first();
                            $card_details = CardDetail::find($card->id);
                            $card_details->owner = $fetcher['owner'];
                            $card_details->cardNumber = $fetcher['cardNumber'];
                            $card_details->cvv = $fetcher['cvv'];
                            $card_details->expiration_month = $fetcher['expiration_month'];
                            $card_details->expiration_year = $fetcher['expiration_year'];
                            $card_details->customer_email = $order->customer_email;
                            $card_details->merchant = 'Rapyd';
                            $card_details->save();
                        } else {

                            $card_details = new CardDetail();
                            $card_details->owner = $fetcher['owner'];
                            $card_details->cardNumber = $fetcher['cardNumber'];
                            $card_details->cvv = $fetcher['cvv'];
                            $card_details->expiration_month = $fetcher['expiration_month'];
                            $card_details->expiration_year = $fetcher['expiration_year'];
                            $card_details->customer_email = $order->customer_email;
                            $card_details->merchant = 'Rapyd';
                            $card_details->save();
                        }
                    }
                }


                $red_url = $result->data->redirect_url;
                return redirect($red_url);
                header("Location: $redirect_url");
            }
            // New Code End
            $order = Order::where("order_number", $order->order_number)->first();
            $total_amount = 0;
            if ($order) {
                $order_trans = OrderPaymentTransaction::where("order_id", $order->id)->first();
                if ($order_trans) {
                    $total_amount = $order_trans->paid_amount;
                } else {
                    session()->flash('error', 'Error Code: ORD-CRE01 (Order transaction details not found, Please contact administration)');
                    return redirect()->back();
                }
            } else {
                session()->flash('error', 'Error Code: ORD-CRE02 (Order details not found, Please contact administration)');
                return redirect()->back();
            }
            $redirec_url = $order->brand_details->redirect_url . "?payment_success=" . $total_amount;
            return $data = ['status' => 1, 'msg' => $redirec_url];
            //return $data = ['status' => 1, 'msg' => route('thanks',['oi' => $order->order_number])];
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }
    private function create_customer($data)
    {
        $secret_key = $data['secret_key'];
        $length = 12;
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $http_method = 'post';   // Lower case.
        $salt = substr(str_shuffle($permitted_chars), 0, $length);  // Randomly generated for each request.
        $date = new DateTime();
        $timestamp = $date->getTimestamp();  // Current Unix time.
        $body = [
            "business_vat_id" => "123456789",
            "email" => $data['customer_email'],
            "invoice_prefix" => "Payment-" . $data['brand_name'],
            "metadata" => array(
                "merchant_defined" => true
            ),
            "name" => $data['name'],
            "phone_number" => $data['phonenumber']
        ];
        $path_maker = '/v1/customers';

        if (env('RAPYD_ENVIRONMENT') == 'sandbox') {
            $base_url = 'https://sandboxapi.rapyd.net'; //sandbox
        } elseif (env('RAPYD_ENVIRONMENT') == 'production') {
            $base_url = 'https://api.rapyd.net'; //production        
        }

        $access_key = $data['access_key'];
        $body_string = !is_null($body) ? json_encode($body, JSON_UNESCAPED_SLASHES) : '';
        $sig_string = "$http_method$path_maker$salt$timestamp$access_key$secret_key$body_string";
        $hash_sig_string = hash_hmac("sha256", $sig_string, $secret_key);
        $signature = base64_encode($hash_sig_string);
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "$base_url$path_maker",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $body_string,

                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    "access_key: $access_key",
                    "salt: $salt",
                    "timestamp: $timestamp",
                    "signature: $signature",
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $result = json_decode($response);

            if (isset($result->status->error_code) && $result->status->error_code != "") {

                $returner = array(
                    'status' => 0,
                    'msg' => $result->status->message
                );

                return $returner;
            }

            $customer_id = json_decode($response)->data->id;

            $returner = array(
                'status' => 1,
                'msg' => $customer_id
            );
            return $returner;
        } catch (Exception $e) {
            $returner = array(
                'status' => 0,
                'msg' => $e->getMessage()
            );
            return $returner;
        }
    }

    public function checkout(Request $request)
    {
        $order = Order::find($request->order_id);
        $config_keys = json_decode(get_merchant_keys($order->brand_name, $order->merchant_id));
        $this->access_key = $config_keys->access_key;
        $this->secret_key = $config_keys->secret_key;
        $en_data = base64_encode(serialize($request->except('_token')));
        $cancel_checkout_url = url()->previous();
        $complete_checkout_url = route('rapyd.response', ['data' => $en_data]);
        $country = "US";
        $currency = $_POST['sale_currency'];
        $language = "en";

        if ((int)($_POST['sale_amount'])) {
            $amount = (int)$_POST['sale_amount'];
            $body = [
                "amount" => $amount,
                "complete_checkout_url" => $complete_checkout_url,
                "country" => $country,
                "currency" => $currency,
                "cancel_checkout_url" => $cancel_checkout_url,
                "language" => $language,
            ];
            try {
                $object = $this->make_request('post', '/v1/checkout', $body);
                if (isset($object["data"]['id'])) {
                    session()->put('page_id', $object["data"]['id']);
                    $redirect_url = $object["data"]["redirect_url"];

                    return redirect($redirect_url);
                    header("Location: $redirect_url");
                } else {
                    return redirect()->back();
                }
            } catch (Exception $e) {
                echo "Error =>$e";
            }
        }
    }

    public function generate_string($length = 12)
    {
        try {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            return substr(str_shuffle($permitted_chars), 0, $length);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    // make_request method - Includes the logic to communicate with the Rapyd sandbox server.
    public function make_request($method, $path, $body = null)
    {
        try {
            if (env('RAPYD_ENVIRONMENT') == 'sandbox') {
                $base_url = 'https://sandboxapi.rapyd.net'; //sandbox
            } elseif (env('RAPYD_ENVIRONMENT') == 'production') {
                $base_url = 'https://api.rapyd.net'; //production        
            }

            $access_key = $this->access_key;     // The access key received from Rapyd.
            $secret_key = $this->secret_key;     // Never transmit the secret key by itself.

            $idempotency = $this->generate_string();      // Unique for each request.
            $http_method = $method;                // Lower case.
            $salt = $this->generate_string();             // Randomly generated for each request.
            $date = Carbon::now();
            $timestamp = $date->getTimestamp();    // Current Unix time.

            $body_string = !is_null($body) ? json_encode($body, JSON_UNESCAPED_SLASHES) : '';
            $sig_string = "$http_method$path$salt$timestamp$access_key$secret_key$body_string";
            $hash_sig_string = hash_hmac("sha256", $sig_string, $secret_key);
            $signature = base64_encode($hash_sig_string);
            $request_data = NULL;

            if ($method === 'post') {
                $request_data = array(
                    CURLOPT_URL => "$base_url$path",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $body_string
                );
            } else {
                $request_data = array(
                    CURLOPT_URL => "$base_url$path",
                    CURLOPT_RETURNTRANSFER => true,
                );
            }
            $curl = curl_init();
            curl_setopt_array($curl, $request_data);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "access_key: $access_key",
                "salt: $salt",
                "timestamp: $timestamp",
                "signature: $signature",
                "idempotency: $idempotency"
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                throw new Exception("cURL Error #:" . $err);
            } else {
                return json_decode($response, true);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function get_response($data)
    {
        $page_id = session()->get('page_id');
        $data = unserialize(base64_decode($data));
        try {
            $object = $this->make_request('get', "/v1/checkout/" . $page_id);  // completed
            $json = json_decode(json_encode($object), true);
            //$json = json_encode($object, true);
            //print_r($json);
            if ($object == '') {
                echo "<br><br><div style='background:red;color:white;padding:8px;border:none;'>Payment Query Updates Failed. Try again</div>";
                exit();
            }
        } catch (Exception $e) {
            echo "<div style='background:red;color:white;padding:8px;border:none;'>Error: $e</div><br><a href = '" . url()->previous() . "'>Go Back</a>";
        }

        $status_success = $json['status']['status'];
        if ($status_success == 'SUCCESS') {  // close if for rapyd success
            $status_success = $json['status']['status'];
            $payment_status  =  $json['data']['payment']['status'];
            $data['payment_id'] = $json['data']['payment']['id'];
            $data['payer_id'] = $json['data']['id'];
            $data['paid_amount'] = $json['data']['payment']['amount'];
            $data['response'] = json_encode($json['data']['payment']);

            $order = Order::find($data['order_id']);
            if (!empty($order)) {
                $order->payment_status = 'paid';
                $order->payment_link = null;
                $order->save();

                $user_data = [];
                $user = new User();
                foreach ($user->getFillable() as $key) {
                    $user_data[$key] = $data[$key];
                }
                if (!User::where('email', $data['email'])->exists()) {
                    User::create($user_data);
                } else {

                    User::where('email', $data['email'])->update($user_data);
                }

                // $pay = OrderPaymentTransaction::create($data);
                // $mail_data = [
                //     'order' => $order,
                //     'payout' => $data
                // ];
                // Mail::to($data['email'])->send(new OrderInvoice($mail_data));

                if (isset($data['cardNumber']) && isset($data['cvv']) && isset($data['owner']) && isset($data['expiration-month']) && isset($data['expiration-year'])) {
                    if (CardDetail::where('customer_email', $order->customer_email)->exists()) {
                        $card = CardDetail::where('customer_email', $order->customer_email)->first();
                        $card_details = CardDetail::find($card->id);
                        $card_details->owner = $data['owner'];
                        $card_details->cardNumber = $data['cardNumber'];
                        $card_details->cvv = $data['cvv'];
                        $card_details->expiration_month = $data['expiration-month'];
                        $card_details->expiration_year = $data['expiration-year'];
                        $card_details->customer_email = $order->customer_email;
                        $card_details->save();
                    } else {
                        $card_details = new CardDetail();
                        $card_details->owner = $data['owner'];
                        $card_details->cardNumber = $data['cardNumber'];
                        $card_details->cvv = $data['cvv'];
                        $card_details->expiration_month = $data['expiration-month'];
                        $card_details->expiration_year = $data['expiration-year'];
                        $card_details->customer_email = $order->customer_email;
                        $card_details->save();
                    }
                }
                session()->forget('page_id');
                return redirect()->route('thanks', ['oi' => $order->order_number]);
            } else {
                return response()->view('errors.404', ['message' => 'Order not found.'], 404);
            }
        }
    }
}
