<?php

namespace App\Http\Controllers;

use App\Mail\PaymentSuccessEmail;
use App\Models\Country;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\CardDetail;
use App\Models\Merchant;
use App\Models\BriefForm;
use App\Models\OrderPackage;
use App\Models\OrderPaymentTransaction;
use App\Mail\OrderInvoice;
use App\Mail\PaymentLink;
use App\Models\Invoice;
use App\Models\UserBrand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
// use Auth;
// use Crypt;
// use Mail;
use Stripe;

class OrderController extends Controller
{
    public function index()
    {
        try {
            if (auth_staff()->role_id == 1) {
                $orders = Order::has('brand_details')->orderBy('id', 'DESC')->get();
            } else {
                $user_brand_ids = UserBrand::where('user_id', auth_staff()->id)->pluck('brand_id')->toArray();
                $orders = Order::has('brand_details')->orderBy('id', 'DESC')->whereIn('brand_name', $user_brand_ids)->get();
            }

            // Support persons = users with the "Project Manager" role.
            $supportPersons = User::where('role_id', support_role_id())->orderBy('firstname')->get();

            // dd($orders);
            return view('admin.orders.index', compact('orders', 'supportPersons'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    /**
     * Assign a new order's client to a support person (Project Manager).
     */
    public function assignSupport(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);

            // Support person can only be assigned to a new order (not an up-sale).
            if ($order->previous_order_id != null) {
                return redirect()->back()->with('error', 'Support person can only be assigned to a new order.');
            }

            $request->validate([
                'support_person_id' => 'required',
            ]);

            $supportPerson = User::where('id', $request->support_person_id)
                ->where('role_id', support_role_id())
                ->first();

            if (!$supportPerson) {
                return redirect()->back()->with('error', 'Invalid support person selected.');
            }

            $order->support_person_id = $supportPerson->id;
            $order->save();

            $supportName = trim(($supportPerson->firstname ?? '') . ' ' . ($supportPerson->lastname ?? '')) ?: $supportPerson->email;

            return redirect()->back()->with('success', 'Client assigned to ' . $supportName . ' successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
    }

    /**
     * Clients assigned to the logged in support person.
     */
    public function assignedClients()
    {
        try {
            $user = auth_staff();

            if ($user->isSuperAdmin()) {
                $assignedOrders = Order::has('brand_details')
                    ->whereNull('previous_order_id')
                    ->whereNotNull('support_person_id')
                    ->orderBy('id', 'DESC')
                    ->get();
            } else {
                $assignedOrders = Order::has('brand_details')
                    ->whereNull('previous_order_id')
                    ->where('support_person_id', $user->id)
                    ->orderBy('id', 'DESC')
                    ->get();
            }

            $emails = $assignedOrders->pluck('customer_email')->filter()->unique()->values();
            $clientIds = $assignedOrders->pluck('user_id')->filter()->unique()->values();
            $orders = Order::with(['brand_details', 'user_details', 'support_person'])
                ->where(function ($query) use ($emails, $clientIds) {
                    if ($emails->isNotEmpty()) {
                        $query->whereIn('customer_email', $emails);
                    }
                    if ($clientIds->isNotEmpty()) {
                        $method = $emails->isNotEmpty() ? 'orWhereIn' : 'whereIn';
                        $query->{$method}('user_id', $clientIds);
                    }
                })
                ->orderByDesc('id')
                ->get();

            $assignedByEmail = $assignedOrders->groupBy('customer_email');
            $clients = $orders->groupBy('customer_email')->map(function ($rows, $email) use ($assignedByEmail) {
                $latest = $rows->first();
                $client = $latest->user_details ?: $latest->user;
                $assignedOrder = optional($assignedByEmail->get($email))->first();

                return (object) [
                    'id' => $client->id ?? $latest->user_id,
                    'email' => $latest->customer_email,
                    'name' => trim(($client->firstname ?? '') . ' ' . ($client->lastname ?? '')) ?: '--',
                    'phone' => $client->billing_phonenumber ?? '--',
                    'orders_count' => $rows->count(),
                    'latest_order_id' => $latest->id,
                    'amount' => $latest->sale_amount,
                    'currency' => $latest->sale_currency,
                    'support_person' => $assignedOrder && $assignedOrder->support_person
                        ? (trim(($assignedOrder->support_person->firstname ?? '') . ' ' . ($assignedOrder->support_person->lastname ?? '')) ?: $assignedOrder->support_person->email)
                        : '--',
                    'orders' => $rows->map(function ($order) {
                        return (object) [
                            'id' => $order->id,
                            'order_number' => $order->order_number,
                            'brand' => $order->brand_details->name ?? '--',
                            'brand_logo' => $order->brand_details->logo ?? null,
                            'amount' => $order->sale_amount,
                            'currency' => $order->sale_currency,
                            'created_at' => $order->created_at,
                            'payment_status' => $order->payment_status,
                            'previous_order_id' => $order->previous_order_id,
                        ];
                    })->values(),
                ];
            })->values();

            $briefForms = collect();
            if ($user->has_permission('send_brief_forms')) {
                $briefForms = BriefForm::where('is_active', true)->orderBy('id')->get(['id', 'title']);
            }

            return view('admin.support.clients', compact('clients', 'briefForms'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
    }

    public function assignedOrderShow($id)
    {
        $order = Order::with(['brand_details', 'user_details', 'packages', 'order_payment_transactions'])
            ->findOrFail($id);
        $user = auth_staff();

        if (Auth::guard('adminiy')->check() && $user->isSuperAdmin()) {
            return view('admin.orders.show', compact('order'));
        }

        if (Auth::guard('user')->check()) {
            $isAssignedClient = Order::whereNull('previous_order_id')
                ->where('support_person_id', $user->id)
                ->where(function ($query) use ($order) {
                    if ($order->user_id) {
                        $query->where('user_id', $order->user_id);
                    }
                    $query->orWhere('customer_email', $order->customer_email);
                })
                ->exists();
            abort_unless($isAssignedClient, 403);
        } elseif (!$user->has_permission('view_assigned_client')) {
            abort(403);
        }

        return view('admin.orders.show', compact('order'));
    }

    // public function ownOrders()
    // {
    //     try {
    //         if (auth_staff()->role_id == 1) {
    //             $orders = Order::has('brand_details')->orderBy('id', 'DESC')->get();
    //         } else {
    //             $user_brand_ids = UserBrand::where('user_id', auth_staff()->id)->pluck('brand_id')->toArray();
    //             $orders = Order::has('brand_details')->orderBy('id', 'DESC')->whereIn('brand_name', $user_brand_ids)->get();
    //         }

    //         // dd($orders);
    //         return view('admin.orders.index', compact('orders'));
    //     } catch (\Throwable $th) {
    //         return redirect()->back()->with('error', "Request :" . $th->getMessage());
    //         throw $th;
    //     }
    // }

    public function customer_orders($email)
    {
        try{
            if(auth_staff()->role_id == 1){
                $orders = Order::has('brand_details')->where('customer_email', $email)->orderBy('id', 'DESC')->get();
            } else{
                $user_brand_ids = UserBrand::where('user_id', auth_staff()->id)->pluck('brand_id')->toArray();
                $orders = Order::has('brand_details')->orderBy('id', 'DESC')->where('customer_email', $email)->whereIn('brand_name', $user_brand_ids)->find($email)->get();
            }
            return view('admin.orders.index', compact('orders'));
        } catch(\Throwable $th){
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function show($id)
    {
        try {
            $order = Order::find($id);
            return view('admin.orders.show', compact('order'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function edit($id)
    {
        try {
            $order = Order::find($id);
            $brands = Brand::where('status', 'active')->get();
            $brand = Brand::find($order->brand_name);
            $brand_packages = $brand ? $brand->packageList()->where('status', 'active')->values() : collect();
            return view('admin.orders.edit', compact('order', 'brands', 'brand_packages'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'payment_type' => 'required',
            'sale_amount' => 'required',
            'sale_currency' => 'required',
            'description' => 'required',
            'brand_name' => 'required',
            'packages' => 'required',
            'sales_email' => 'required|email',
            'customer_email' => 'required|email',

        ]);
        try {
            $order = Order::find($id);
            $order->payment_type = $request->payment_type;
            $order->sale_amount = $request->sale_amount;
            $order->sale_currency = $request->sale_currency;
            $order->description = $request->description;
            $order->save();

            if ($request->packages != null) {
                OrderPackage::where('order_id', $order->id)->delete();
                foreach ($request->packages as $key => $package) {
                    OrderPackage::create(['order_id' => $order->id, 'package_id' => $package]);
                }
                // $link = Crypt::encryptString($order->id);
                // $order->expires_at = now()->addHours(24);
                // $order->payment_link = route('payment.terminal', ['link' => $link]);
                // $mail_data = [
                //     'order' => $order,
                // ];
                // Mail::to($order->customer_email)->send(new PaymentLink($mail_data));
                $order->save();
                if ($order) {
                    try {
                        $mail_data = [
                            'order' => $order,
                        ];
                        // Mail::to($order->customer_email)->send(new PaymentLink($mail_data));
                    } catch (\Throwable $th) {
                        //throw $th;
                        Log::error('Order update email failed', ['error' => $th->getMessage()]);
                    }
                    
                    return redirect()->back()->with('success', 'Order updated successfully');
                }
            } else {
                return redirect()->back()->with('error', 'Order updated failed');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            $order->order_packages()->delete();
            $order->order_payment_transactions()->delete();
            return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function order_store(Request $request)
    {
        // A non-admin staff member (users-table login) cannot choose the
        // salesperson email - it is always their own email.
        $staff = auth_staff();
        if ($staff instanceof User) {
            $request->merge(['sales_email' => $staff->email]);
        }

        $rules = [
            'payment_type' => 'required|in:1,2',
            'sale_amount' => 'required|numeric|min:1',
            'sale_currency' => 'required',
            'description' => 'required',
            'brand_name' => 'required',
            'payment_gateway' => 'required',
            'packages' => 'required|array|min:1',
            'sales_email' => 'required|email',
            'customer_email' => 'required|email',
        ];

        // Up-Sale payments must reference the original order.
        if ($request->payment_type == 2) {
            $rules['order_id'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        // Brand must exist and be active.
        $brand = Brand::where('id', $request->brand_name)->where('status', 'active')->first();
        if (!$brand) {
            return back()->withInput()->with('error', 'Invalid brand selected.');
        }

        // Merchant must exist, be active and belong to the selected brand.
        $merchant = Merchant::find($request->payment_gateway);
        $brand_merchant_ids = $brand->merchantList()->pluck('id')->map(function ($id) {
            return (int) $id;
        })->toArray();
        if (!$merchant || $merchant->status != 'active' || !in_array((int) $merchant->id, $brand_merchant_ids)) {
            return back()->withInput()->with('error', 'Selected merchant does not belong to the selected brand.');
        }

        // Every selected package must belong to the selected brand.
        $brand_package_ids = $brand->packageList()->pluck('id')->map(function ($id) {
            return (int) $id;
        })->toArray();
        $selected_packages = array_map('intval', (array) $request->packages);
        if (!empty(array_diff($selected_packages, $brand_package_ids))) {
            return back()->withInput()->with('error', 'Selected package does not belong to the selected brand.');
        }

        // Up-Sale: the previous order must exist.
        $previous_order = null;
        if ($request->payment_type == 2) {
            $previous_order = Order::find($request->order_id);
            if (!$previous_order) {
                $previous_order = Order::where('order_number', $request->order_id)->first();
            }
            if (!$previous_order) {
                return back()->withInput()->with('error', 'Previous order not found for ID: ' . $request->order_id);
            }
        }

        try {
            DB::beginTransaction();

            /* ------------------------------------------------------------------
             * Step 1 - Resolve (or create) the client user.
             * For an up-sale we always re-use the original order's customer so
             * that we never create an unrelated/duplicate customer.
             * ------------------------------------------------------------------ */
            $customer_email = ($previous_order && $previous_order->customer_email)
                ? $previous_order->customer_email
                : $request->customer_email;

            $client = User::where('email', $customer_email)->first();
            if (!$client) {
                $client = User::create([
                    'firstname' => explode('@', $customer_email)[0],
                    'lastname' => '',
                    'billing_address' => '',
                    'billing_phonenumber' => '',
                    'email' => $customer_email,
                    'role_id' => client_role_id(),
                    'password' => Hash::make(Str::random(16)),
                    'is_active' => 1,
                ]);
            }

            /* ------------------------------------------------------------------
             * Step 2 - Create the order (the up-sale record for payment_type = 2).
             * ------------------------------------------------------------------ */
            $order = new Order();
            $order->payment_type = (int) $request->payment_type;
            $order->sale_amount = $request->sale_amount;
            $order->sale_currency = $request->sale_currency;
            $order->description = $request->description;
            $order->brand_name = $brand->id;
            $order->payment_gateway = $merchant->merchant;
            $order->merchant_id = $merchant->id;
            $order->user_id = $client->id;
            $order->sales_email = $request->sales_email;
            $order->customer_email = $customer_email;
            $order->status = 'pending';
            $order->payment_status = 'unpaid';
            if ($previous_order) {
                $order->previous_order_id = $previous_order->id;
            }
            $order->save();

            $order->order_number = str_pad($order->id, 5, '0', STR_PAD_LEFT);

            foreach ($selected_packages as $package_id) {
                OrderPackage::create(['order_id' => $order->id, 'package_id' => $package_id]);
            }

            /* ------------------------------------------------------------------
             * Step 3 - Generate a unique payment link for this order.
             * ------------------------------------------------------------------ */
            $link = $this->encode_id($order->id);
            $order->expires_at = Carbon::parse(date('Y-m-d'))->addMonth(1);
            $order->payment_link = route('payment.terminal', [
                'brander' => $brand->slug,
                'link' => $link,
            ]);
            $order->save();

            $invoice = new Invoice();
            $invoice->order_id = $order->id;
            $invoice->amount = $order->sale_amount;
            $invoice->payment_link = $order->payment_link;
            $invoice->save();

            DB::commit();

            // Return to the create form so the generated payment link is shown to
            // the admin (flash message) instead of dropping them on the client page.
            return redirect()->route('payment.create_order')
                ->with('success', 'Order created successfully. Payment link: ' . $order->payment_link);
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withInput()->with('error', "Request :" . $th->getMessage());
        }
    }

    public function request_payment_link(Request $request, $id)
    {
        // dd($request);
        $validator = Validator::make($request->all(),[
            'expiry_date' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            $order = Order::findOrFail($id);
            if($order->payment_status == 'paid'){
                return redirect()->back()->with('success', "Request Failed! #".$order->order_number." order is already paid.");
            }
            $brand_slug = optional($order->brand_details)->slug;
            if(!$brand_slug){
                return redirect()->back()->with('error', "Brand not found for this order.");
            }
            $link = $this->encode_id($order->id);
            $order->expires_at = $request->expiry_date;
            $order->payment_link = route('payment.terminal', ['brander' => $brand_slug, 'link' => $link]);
            
            try {
                $mail_data = [
                    'order' => $order,
                ];
                // Mail::to($order->customer_email)->send(new PaymentLink($mail_data));
            } catch (\Throwable $th) {
                //throw $th;
                Log::error('New payment link email failed', ['error' => $th->getMessage()]);
            }

            $order->save();
            return redirect()->back()->with('success', "Payment link updated successfully");
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function payment_terminal($brander,$link)
    {
        try {
            $order_id = $this->decode_id($link);
            $order = $order_id ? Order::find($order_id) : null;

            if (!$order) {
                return response()->view('errors.404', ['message' => 'Order not found.'], 404);
            }

            // The brand slug in the URL must match the order's brand.
            $brand_slug = optional($order->brand_details)->slug;
            if ($brand_slug && strcasecmp($brand_slug, $brander) !== 0) {
                return response()->view('errors.404', ['message' => 'Order not found.'], 404);
            }

            // Already paid / link consumed -> block a second payment.
            if ($order->payment_status == 'paid' || empty($order->payment_link)) {
                return response()->view('errors.400', ['message' => 'This order has already been paid.'], 400);
            }

            // The token in the URL must be the order's current payment token.
            if ($this->payment_link_token($order->payment_link) !== $link) {
                return response()->view('errors.404', ['message' => 'Order not found.'], 404);
            }

            if ($order->expires_at && Carbon::parse($order->expires_at)->toDateString() < now()->toDateString()) {
                return response()->view('errors.500', ['message' => 'The order has expired.', 'order' => $order], 500);
            }

            $merchants = get_brand_merchants($order->brand_name);
            $currency_mode = $order->sale_currency;

            $countries = Country::all();

            if ($order->status == 'pending') {
                switch ($order->merchant_id) {
                    case '1':
                        return $this->redirectToPaypal($order, $merchants, $currency_mode, $countries);
                    case '2':
                        return $this->redirectToStripe($order, $merchants, $currency_mode, $countries);
                    case '3':
                        return $this->redirectToSquare($order, $merchants, $currency_mode, $countries);
                    case '4':
                        return $this->redirectToAuthorize($order, $merchants, $currency_mode, $countries);
                    case '5':
                        return $this->redirectToRapyd($order, $merchants, $currency_mode, $countries);
                    case '6':
                        return $this->redirectToChase($order, $merchants, $currency_mode, $countries);
                    default:
                        return response()->view('errors.400', ['message' => 'Invalid merchant ID.'], 400);
                }
            } else {
                return response()->view('errors.400', ['message' => 'Order status is not pending.'], 400);
            }
        } catch (\Throwable $th) {
            Log::error("Payment terminal failed: {$th->getMessage()}");
            return response()->view('errors.404', ['message' => 'Order not found.'], 404);
        }
    }

    /**
     * Extract the payment token (last URL segment) from a stored payment link.
     */
    private function payment_link_token($url)
    {
        if (empty($url)) {
            return null;
        }

        $path = parse_url($url, PHP_URL_PATH);

        return $path ? basename($path) : null;
    }

    public function redirectToStripe($order, $merchants, $currency_mode, $countries)
    {
        $config_keys = json_decode(get_merchant_keys($order->brand_name, $order->merchant_id));
        $brandName = $order->brand_details->name;

        $words = explode(' ', $brandName);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper($word[0]); // H + F + A = HFA
        }
        
        \Stripe\Stripe::setApiKey($config_keys->stripe_secret_key);
        $amount = $order->sale_amount;
        
        $intent = \Stripe\PaymentIntent::create([
            'amount' => ($amount) * 100,
            'currency' => $order->sale_currency,
            'metadata' => ['integration_check' => 'accept_a_payment'],
            'statement_descriptor_suffix' => "Payment - " . $initials,
            'description' => "Payment from - " . $order->brand_details->name,
        ]);
        $data = array(
            'email' => $order->customer_email,
            'amount' => $amount,
            'client_secret' => $intent->client_secret,
        );
        
        return view('payment_terminals.stripe', compact('order', 'merchants', 'data', 'currency_mode', 'countries'));
    }

    public function redirectToPaypal($order, $merchants, $currency_mode, $countries)
    {
        return view('payment_terminals.paypal', compact('order', 'merchants', 'currency_mode', 'countries'));
    }

    public function redirectToSquare($order, $merchants, $currency_mode, $countries)
    {
        return view('payment_terminals.square', compact('order', 'merchants', 'currency_mode', 'countries'));
    }

    public function redirectToAuthorize($order, $merchants, $currency_mode, $countries)
    {
        return view('payment_terminals.authorize', compact('order', 'merchants', 'currency_mode', 'countries'));
    }

    public function redirectToRapyd($order, $merchants, $currency_mode, $countries)
    {
        return view('payment_terminals.rapyd', compact('order', 'merchants', 'currency_mode', 'countries'));
    }

    public function redirectToChase($order, $merchants, $currency_mode, $countries)
    {
        return view('payment_terminals.chase', compact('order', 'merchants', 'currency_mode', 'countries'));
    }

    public function payout(Request $request)
    {
        try {
            $order = Order::findOrFail($request->order_id);

            // Never process the same order twice.
            if ($order->payment_status == 'paid') {
                return redirect()->route('thanks', ['oi' => $order->order_number]);
            }

            DB::beginTransaction();
            $data = $request->except('_token');
            $data['billing_address'] = $data['billing_phonenumber'];
            $user = new User();
            $user_data = $request->only($user->getFillable());
            $user_data['billing_address'] = $user_data['billing_phonenumber'];

            // PDF GENERATION
            // Generate PDF with payment details
            // $brand_logo_path = $order->brand_details->logo;
            // $brand_logo_type = pathinfo($brand_logo_path, PATHINFO_EXTENSION);
            // $brand_logo_data = file_get_contents($brand_logo_path);
            //$brand_logo_base64 = 'data:image/' . $brand_logo_type . ';base64,' . base64_encode($brand_logo_data);
            
            $sign = '';
            if(isset($data['signature']) && $data['signature'] != '' && $data['signature'] != null){
                $sign = $data['signature'];
            }
            
            /*
            $pdf_data = [
                'name' => $data['firstname'].' '.$data['lastname'],
                'brand_name' => $order->brand_details->name,
                'brand_logo_base64' => $brand_logo_base64,
                'signature' => $sign,
            ];
            $pdf = \PDF::loadView('admin.agreement', compact('pdf_data'));
            $pdf->setOptions(['defaultFont' => 'sans-serif', 'fontDir' => public_path('fonts/LibreBaskerville-Regular.ttf')]); 
            */
            
            // Define PDF file path and name
            
            
            // $pdfFile = strtoupper($order->brand_details->name).'_GENERAL_AGREEMENT_' . $order->order_number . '.pdf';
            // $folderPath = public_path('pdf');
            // if (!File::isDirectory($folderPath)) {
            //     try {
            //         File::makeDirectory($folderPath, 0755, true);
            //     } catch (\Exception $e) {
            //         // Log the error or handle it appropriately
            //         Log::error("Failed to create directory: {$folderPath}. Error: {$e->getMessage()}");
            //         // return; 
            //     }
            // }

            // $pdfFilePublicPath = $folderPath.'/'.$pdfFile;
            // $pdfFilePath = 'pdf/'.$pdfFile;
            
            $pdfFilePath = '';
            // try {
            //     $pdf->save($pdfFilePublicPath);
            // } catch (\Exception $e) {
            //     // Log the error or handle it appropriately
            //     Log::error("Failed to save PDF file: {$pdfFilePath}. Error: {$e->getMessage()}");
            //     // return;
            // }
            // PDF GENERATION

            $order->payment_status = 'paid';
            $order->signature = $sign;
            $order->payment_link = null;
            $order->pdf_agreement = $pdfFilePath;
            $order->save();

            // Keep the client (customer) record in sync with the payment form details.
            $client = !empty($data['email']) ? User::where('email', $data['email'])->first() : null;
            if ($client) {
                $client->update($user_data);
            } elseif (!empty($data['email'])) {
                $user_data['role_id'] = client_role_id();
                $client = User::create($user_data);
            }

            // Keep this payment linked to the correct order + client.
            if ($client) {
                $order->user_id = $client->id;
                $order->save();
            }

            // user_id  -> the staff/user who created the order link (salesperson).
            // client_id -> the customer who actually paid.
            $sales_user = !empty($order->sales_email)
                ? User::where('email', $order->sales_email)->first()
                : null;
            $data['user_id'] = $sales_user ? $sales_user->id : null;
            $data['client_id'] = $client ? $client->id : null;

            $pay = OrderPaymentTransaction::create($data);
            $mail_data = [
                'order' => $order,
                'payout' => $data
            ];
            //Mail::to($data['email'])->send(new OrderInvoice($mail_data));
            
            if (isset($data['cardNumber'], $data['cvv'], $data['owner'], $data['expiration-month'], $data['expiration-year'])) {
                $card_details = CardDetail::updateOrCreate(
                    ['customer_email' => $order->customer_email],
                    [
                        'owner' => $data['owner'],
                        'cardNumber' => $data['cardNumber'],
                        'cvv' => $data['cvv'],
                        'expiration_month' => $data['expiration-month'],
                        'expiration_year' => $data['expiration-year'],
                        'merchant' => $data['payment_method'],
                    ]
                );
            }
            
            DB::commit();
            // Send payment success email. A mail failure must never invalidate
            // an already-committed successful payment.
            try {
                $email = new PaymentSuccessEmail($order);
                Mail::to($order->customer_email)->send($email);
            } catch (\Throwable $th) {
                Log::error("Failed to send payment mail. Error: {$th->getMessage()}");
            }
            return redirect()->route('thanks', ['oi' => $order->order_number]);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error("Payment process failed: {$th->getMessage()}");
            return redirect()->back()->with('error', "Request Failed:" . $th->getMessage());
            throw $th;
        }
    }

    public function thanks($oi = null)
    {
        try {
            $order = Order::where("order_number", $oi)->first();
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
            // $redirec_url = $order->brand_details->redirect_url."?payment_success=".$total_amount;
            // return redirect($redirec_url);
            return view('thanks', compact('oi'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function status($order_id, $status)
    {
        try {
            $order = Order::find($order_id);
            $order->status = $status;
            $order->save();
            session()->flash('success', 'Order status changed successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
    }

    public function create_order()
    {
        try {
            $user = auth_staff();
            if (!$user) {
                return redirect()->route('admin.login');
            }
            $brands = Brand::where('status', 'active')->get();
            // A users-table staff member must use their own email as the salesperson.
            $is_staff_user = $user instanceof User;
            return view('admin.orders.create_order', compact('brands', 'user', 'is_staff_user'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function signatureSave(Request $request)
    {
        // dd($request);
        // Validate the request to ensure 'invoice_number' and 'signature' are provided
        $request->validate([
            'order_id' => 'required|string',
            'signature' => 'required|string',
        ]);

        // Find the payment record using the invoice number
        $order = Order::find($request->order_id);

        // Check if the payment record exists
        if ($order) {
            // Update the signature field
            $order->update(['signature' => $request->signature]);

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Signature saved successfully!',
            ]);
        } else {
            // Return an error response if the payment is not found
            return response()->json([
                'status' => 'error',
                'message' => 'Payment not found.',
            ], 404); // Return a 404 Not Found status
        }
    }
    
    private function encode_id($num) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $base = strlen($characters);
        $encoded = '';
        while ($num > 0) {
            $encoded = $characters[$num % $base] . $encoded;
            $num = floor($num / $base);
        }
    
        // Pad the encoded string to always be 6 characters
        return str_pad($encoded, 6, 'a', STR_PAD_LEFT);
    }
    
    private function decode_id($encoded) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $base = strlen($characters);
        $encoded = ltrim($encoded, 'a'); // Remove padding before decoding
        $length = strlen($encoded);
        $num = 0;
        for ($i = 0; $i < $length; $i++) {
            $num = $num * $base + strpos($characters, $encoded[$i]);
        }
        return $num;
    }
}
