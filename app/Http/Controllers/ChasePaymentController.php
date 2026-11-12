<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Http;
use Illuminate\Http\Request;
use Log;

class ChasePaymentController extends Controller
{
    public $client_id;
    public $client_secret;

    public function chasePayment(Request $request)
    {
        $order = Order::find($request->order_id);
        $config_keys = json_decode(get_merchant_keys($order->brand_name, $order->merchant_id));
        $this->client_id = $config_keys->client_id;
        $this->client_secret = $config_keys->client_secret;


        // 1. Validate the request (important!)
        $request->validate([
            'sale_amount' => 'required|numeric|min:0.01', // Example validation
            'card_number' => 'required', // Add more thorough card validation if not using a tokenized approach
            'exp_month' => 'required',
            'exp_year' => 'required',
            'cvv_number' => 'required',
            // ... other required fields
        ]);



        // 2. Get data from the request
        $amount = (int)$_POST['sale_amount'];
        $cardNumber = $request->input('card_number'); // Handle with EXTREME caution!  Tokenization is highly recommended.
        $expiryMonth = $request->input('exp_month');
        $expiryYear = $request->input('exp_year');
        $cvv = $request->input('cvv_number');
        $orderId = 'ORDER_' . time(); // Generate a unique order ID
        // ... other data (customer info, billing address, etc.)

        // 3. Get access token (using the function below)
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            dd($accessToken);
            Log::error('Failed to get access token from Chase.');
            return back()->withErrors(['payment' => 'Payment processing failed.']);
        }


        // 4. Get Chase credentials
        $merchantId = mt_rand(8,12);
        $terminalId = mt_rand(8).'-'.mt_rand(4).'-'.mt_rand(4).'-'.mt_rand(4).'-'.mt_rand(12);

        dd($merchantId,$terminalId);

        // 5. Prepare the API request (This is a simplified example - adapt to Chase's API spec)
        $requestData = [
            'merchant_id' => $merchantId,
            'terminal_id' => $terminalId,
            'amount' => $amount,
            'currency' => 'USD', // Or your currency
            'order_id' => $orderId,
            'card' => [ // Or however Chase structures card data
                'number' => $cardNumber,  // Again, handle securely! Tokenization is best.
                'expiry_month' => $expiryMonth,
                'expiry_year' => $expiryYear,
                'cvv' => $cvv,
            ],
            // ... other required fields (billing address, etc.)
        ];

        // 6. Make the API request
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
        ])->post('CHASE_API_ENDPOINT', $requestData); // Replace with the *actual* Chase API endpoint

        // 7. Process the response
        if ($response->successful()) {
            $responseData = $response->json();
            Log::info('Chase Payment Response:', $responseData); // Log the response for debugging

            // Example: Check for success (adapt to Chase's actual response structure)
            if (isset($responseData['status']) && $responseData['status'] == 'approved') { // Or whatever Chase returns
                return redirect('/payment/success?order_id=' . $orderId); // Redirect to success page
            } else {
                $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'Payment declined.';
                Log::error('Chase Payment Error:', $responseData);
                return back()->withErrors(['payment' => $errorMessage]);
            }
        } else {
            $errorData = $response->json();
            Log::error('Chase API Error:', $errorData);
            return back()->withErrors(['payment' => 'Payment processing failed.']); // Or more specific error
        }
    }

    private function getAccessToken()
    {
        $clientId = $this->client_id;
        $clientSecret = $this->client_secret;
        $url = "https://id.payments.jpmorgan.com/am/oauth2/alpha/access_token";

        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        // CURLOPT_URL => 'https://id.payments.jpmorgan.com/am/oauth2/alpha/access_token',
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // CURLOPT_CUSTOMREQUEST => 'POST',
        // CURLOPT_POSTFIELDS => 'grant_type=client_credentials&scope=jpm:payments:sandbox&client_id='.$clientId.'&client_secret='.$clientSecret,
        // CURLOPT_HTTPHEADER => array(
        //     'Content-Type: application/x-www-form-urlencoded',
        // ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);
        // echo $response;
        // print_r($response);die();
        
        // dd($clientId,$clientSecret);
        $response = Http::withBasicAuth($clientId, $clientSecret)->asForm()->post($url, [
            "grant_type" => "client_credentials",
            "scope" => "jpm:payments:sandbox" // Or your required scope
        ]);

        dd($response);
        if ($response->successful()) {
            $token = $response->json()['access_token'];
            cache(['chase_access_token' => $token], now()->addHour(1)); // Cache the token
            return $token;
        } else {
            Log::error('Chase OAuth Error:', $response->json()); // Log the error
            return null;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
