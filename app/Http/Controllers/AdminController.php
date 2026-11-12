<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Brand;
use App\Models\OrderPaymentTransaction;
use App\Models\User;
use App\Models\UserBrand;

use Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
// use DB;
// use Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class AdminController extends Controller
{
    public function index()
    {
        try {
            $user_brand_ids = UserBrand::where('user_id', auth_staff()->id)->pluck('brand_id')->toArray();
            if (auth_staff()->role_id == 1) {
                $order = Order::select('sale_amount')->get()->toArray();
            } else {
                $order = Order::select('sale_amount')->whereIn("brand_name", $user_brand_ids)->get()->toArray();
            }
            $arrays = array();
            $all_dues = 0;
            foreach ($order as $object) {
                $arrays[] = $object['sale_amount'];
                $all_dues += $object['sale_amount'];
            }
            $total_order_generated = implode(",", $arrays);
            $total_order_count = count($arrays);
            $data['total_order_generated'] = $total_order_generated;
            $data['total_order_count'] = $total_order_count;
            $data['all_dues'] = $all_dues;

            // Current Day Order
            if (auth_staff()->role_id == 1) {
                $order_today = Order::select('sale_amount')->whereDate('created_at', Carbon::today())->get()->toArray();
            } else {
                $order_today = Order::select('sale_amount')->whereIn("brand_name", $user_brand_ids)->whereDate('created_at', Carbon::today())->get()->toArray();
            }
            $today_arrays = array();
            $today_dues = 0;
            foreach ($order_today as $object) {
                $today_arrays[] = $object['sale_amount'];
                $today_dues += $object['sale_amount'];
            }
            $today_order_generated = implode(",", $today_arrays);
            $today_order_count = count($today_arrays);
            $data['today_order_generated'] = $today_order_generated;
            $data['today_order_count'] = $today_order_count;
            $data['today_dues'] = $today_dues;

            // Paid Order
            if (auth_staff()->role_id == 1) {
                $order_paid = Order::select('sale_amount')->where('payment_status', 'paid')->get()->toArray();
            } else {
                $order_paid = Order::select('sale_amount')->whereIn("brand_name", $user_brand_ids)->where('payment_status', 'paid')->get()->toArray();
            }
            $arrays_paid = array();
            $all_paid = 0;
            foreach ($order_paid as $object) {
                $arrays_paid[] = $object['sale_amount'];
                $all_paid += $object['sale_amount'];
            }
            $total_paid_generated = implode(",", $arrays_paid);
            $total_paid_count = count($arrays_paid);
            $data['total_paid_generated'] = $total_paid_generated;
            $data['total_paid_count'] = $total_paid_count;
            $data['all_paid'] = $all_paid;

            // Current Day Paid Order
            if (auth_staff()->role_id == 1) {
                $order_today_paid = Order::select('sale_amount')->where('payment_status', 'paid')->whereDate('created_at', Carbon::today())->get()->toArray();
            } else {
                $order_today_paid = Order::select('sale_amount')->whereIn("brand_name", $user_brand_ids)->where('payment_status', 'paid')->whereDate('created_at', Carbon::today())->get()->toArray();
            }
            $today_paid_arrays = array();
            $today_paid = 0;
            foreach ($order_today_paid as $object) {
                $today_paid_arrays[] = $object['sale_amount'];
                $today_paid += $object['sale_amount'];
            }
            $today_paidorder_generated = implode(",", $today_paid_arrays);
            $today_paidorder_count = count($today_paid_arrays);
            $data['today_paidorder_generated'] = $today_paidorder_generated;
            $data['today_paidorder_count'] = $today_paidorder_count;
            $data['today_paid'] = $today_paid;

            // Month Paid Report
            if (auth_staff()->role_id == 1) {
                $month_report = Order::select(
                    DB::raw("(sum(sale_amount)) as total_amount"),
                    DB::raw("MONTHNAME(created_at) as month_name")
                )
                    ->whereYear('created_at', date('Y'))
                    ->groupBy('month_name')
                    ->where('payment_status', 'paid')

                    ->get()
                    ->toArray();
            } else {
                $month_report = Order::select(
                    DB::raw("(sum(sale_amount)) as total_amount"),
                    DB::raw("MONTHNAME(created_at) as month_name")
                )
                    ->whereYear('created_at', date('Y'))
                    ->groupBy('month_name')
                    ->where('payment_status', 'paid')
                    ->whereIn("brand_name", $user_brand_ids)
                    ->get()
                    ->toArray();
            }
            $months = array();
            $amounts = array();
            foreach ($month_report as $report) {
                $months[] = '"' . $report['month_name'] . '"';
                $amounts[] = $report['total_amount'];
            }
            $months_report_name = implode(',', $months);
            $months_report_amount = implode(',', $amounts);
            $data['months_report_name'] = $months_report_name;
            $data['months_report_amount'] = $months_report_amount;

            // All users
            $all_users = User::orderBy('created_at', 'desc')->get();

            // Sales Report Brand Wise
            $query = Order::select(
                DB::raw("SUM(sale_amount) as total_amount"),
                DB::raw("SUM(orders.status) as order_status"),
                DB::raw("brands.name as brand_name")
            )->leftJoin('brands', 'orders.brand_name', '=', 'brands.id')
                ->where('payment_status', 'paid');
            if (auth_staff()->role_id != 1) {
                $query->whereIn('brand_name', $user_brand_ids);
            }
            $brand_orders = $query->groupBy('brands.name')
                ->orderBy('total_amount', 'desc')
                ->get()
                ->toArray();

            $order_trans = OrderPaymentTransaction::get();

            return view('admin.index')->with(compact('data', 'all_users', 'brand_orders'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }
    public function chnage_password(){
        return view('admin.profile.change_password');
    }

    public function update_password(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed', // 'confirmed' checks if password and password_confirmation match
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        
        $user = auth_staff(); // Assuming you're using an 'admin' guard
        // dd($user);
        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password does not match.'])->withInput();
        }

        // Update the password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

}
