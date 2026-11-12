<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $brands = Brand::where('status', 'active')->get();
            return view('welcome', compact('brands'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }
    public function brand_packages(Request $request)
    {
        try {
            $brand = Brand::find($request->brand_id);
            $merchants = $brand->merchantList()->where('status', 'active')->values();
            $packages = $brand->packageList()->where('status', 'active')->values();
            $merchant_view = view('ajax.merchants', compact('merchants'))->render();
            $packages_view = view('ajax.packages', compact('packages'))->render();
            $currency_view = view('ajax.currency', compact('brand'))->render();
            return response()->json(['merchants' => $merchant_view, 'packages' => $packages_view, 'currency' => $currency_view], 200);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }
}
