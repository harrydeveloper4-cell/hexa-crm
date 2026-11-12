<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Package;
use App\Models\Merchant;
use App\Models\OrderPackage;
use App\Models\CardDetail;
use App\Models\OrderPaymentTransaction;
use App\Models\UserBrand;
use Illuminate\Support\Facades\Validator;
use App\Mail\OrderInvoice;
use App\Mail\PaymentLink;
use Crypt;
use Mail;
// use Auth;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        try {
            if (auth_staff()->role_id == 1) {
                $transactions = OrderPaymentTransaction::orderBy('order_id', 'desc')->get();
            } else {
                $user_brand_ids = UserBrand::where('user_id', auth_staff()->id)->pluck('brand_id')->toArray();
                $orders = Order::whereIn("brand_name", $user_brand_ids)->pluck('id')->toArray();
                $transactions = OrderPaymentTransaction::whereIn("order_id", $orders)->orderBy('order_id', 'desc')->get();
            }
            return view('admin.transactions.index', compact('transactions'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function payment_recuring()
    {
        try {
            $customers = User::whereIn('email', function ($query) {
                $query->select('customer_email')
                    ->from('card_details')
                    ->whereColumn('card_details.customer_email', 'users.email');
            })->get();
            return view('admin.transactions.payment-recuring', compact('customers'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function customer_transactions(Request $request)
    {
        try {
            $transactions = OrderPaymentTransaction::orderBy('id', 'DESC')->where('email', $request->email)->get();
            $records = view('admin.transactions.records', compact('transactions'))->render();
            return response()->json(['records' => $records], 200);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function customer_card_details(Request $request)
    {
        try {
            $card_details = CardDetail::where('customer_email', $request->email)->first()->toArray();
            if (!empty($card_details)) {
                $card_details['last4'] = substr($card_details['cardNumber'], 15, 19);
                return response()->json($card_details, 200);
            } else {
                return response()->json(['msg' => 'Not Found'], 404);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function merchant_configs(Request $request)
    {
        try {
            $order = Order::find($request->order_id);
            $config_keys = json_decode(get_merchant_keys($order->brand_name, $order->merchant_id));
            return response()->json($config_keys, 200);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function payment_recharge(Request $request)
    {
        try {
            $data = $request->except('_token');
            $order = Order::find($data['order_id']);
            $user = User::where('email', $request->email)->addSelect(['firstname', 'lastname', 'billing_address', 'country', 'state', 'city', 'postalcode', 'email', 'billing_phonenumber'])->first()->toArray();
            $new_data = array_merge($user, $data);
            $pay = OrderPaymentTransaction::create($new_data);
            // $mail_data = [
            //     'order' => $order,
            //     'payout' => $new_data
            // ];
            //Mail::to($data['email'])->send(new OrderInvoice($mail_data));
            if (!empty($pay)) {
                session()->flash('success', 'Payment charged successfully');
            } else {
                session()->flash('error', 'Payment request failed');
            }
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }
}
