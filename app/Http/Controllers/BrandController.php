<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Merchant;
use App\Models\Currency;
use App\Models\Package;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $brands = Brand::all();
            return view('admin.brands.index', compact('brands'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $currencies = DB::table('currency')->get();
            $packages = Package::where('is_deleted', '0')->get();
            $merchants = Merchant::orderBy('merchant')->get();
            return view('admin.brands.create', compact('currencies', 'packages', 'merchants'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'name' => 'required',
                'phonenumber' => 'required',
                'email_address' => 'required',
                'description' => 'required',
                'link' => 'required|url',
                'logo' => 'required|image|mimes:jpg,jpeg,png,bmp',
                'currencies' => 'required',
                'packages' => 'nullable|array',
                'merchants' => 'nullable|array',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            $link = $request->link;
            $link = preg_replace('#^https?://#', '', $link);
            $link = preg_replace('#^www\.#', '', $link);
            $host = parse_url('http://' . $link, PHP_URL_HOST);
            $mainDomain = explode('.', $host)[0];
            
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->phonenumber = $request->phonenumber;
            $brand->email_address = $request->email_address;
            $brand->desc = $request->description;
            $brand->link = $request->link;
            $brand->slug = $mainDomain;
            $brand->currency = json_encode($request->currencies);
            $brand->packages = $request->input('packages', []);
            $brand->merchant = $request->input('merchants', []);

            if ($request->hasFile('logo') != null) {

                $logo = $request->file('logo');
                $logo_ext = $logo->getClientOriginalExtension();
                $logo_name = time() . '_brand_logo.' . $logo_ext; // Unique logo Name
                $logo_path = 'brand_uploads';
                // Save logo to notice_uploads directory
                $logo->move(public_path($logo_path), $logo_name);
                // Save logo in db
                $brand->logo = $logo_path . "/" . $logo_name;
            }
            $brand->save();
            return redirect()->route('admin.brands.index')->with('success', 'Brand Created Successfully');
        } catch (\Throwable $th) {
            // throw $th;
            Log::error('Brand Created Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
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
        try {
            $brand = Brand::find($id);
            $currencies = Currency::get();
            $packages = Package::where('is_deleted', '0')->get();
            $merchants = Merchant::orderBy('merchant')->get();
            return view('admin.brands.edit', compact('brand', 'currencies', 'packages', 'merchants'));
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Brand Edit Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
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
        $request->validate([
            'name' => 'required',
            'phonenumber' => 'required',
            'email_address' => 'required',
            'description' => 'required',
            'link' => 'required',
            'logo' => 'nullable|image',
            'currencies' => 'required',
            'packages' => 'nullable|array',
            'merchants' => 'nullable|array',
        ]);

        try {
            $brand = Brand::find($id);
            $brand->name = $request->name;
            $brand->phonenumber = $request->phonenumber;
            $brand->email_address = $request->email_address;
            $brand->desc = $request->description;
            $brand->link = $request->link;
            
            $link = $request->link;
            $link = preg_replace('#^https?://#', '', $link);
            $link = preg_replace('#^www\.#', '', $link);
            $host = parse_url('http://' . $link, PHP_URL_HOST);
            $mainDomain = explode('.', $host)[0];
            $brand->slug = $mainDomain;
            
            $brand->currency = json_encode($request->currencies);
            $brand->packages = $request->input('packages', []);
            $brand->merchant = $request->input('merchants', []);

            if ($request->hasFile('logo') != null) {
                if (isset($brand->logo) && File::exists(public_path($brand->logo))) {
                    File::delete(public_path($brand->logo));
                }
                $logo = $request->file('logo');
                $logo_ext = $logo->getClientOriginalExtension();
                $logo_name = time() . '_brand_logo.' . $logo_ext; // Unique logo Name
                $logo_path = 'brand_uploads';
                // Save logo to notice_uploads directory
                $logo->move(public_path($logo_path), $logo_name);
                // Save logo in db
                $brand->logo = $logo_path . "/" . $logo_name;
            }
            $brand->save();
            return redirect()->route('admin.brands.index')->with('success', 'Brand Updated Successfully');
        } catch (\Throwable $th) {
            // throw $th;
            Log::error('Brand Updated Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
    }

    public function brand_merchants_edit(Request $request)
    {
        $request->validate([
            'brand' => 'required|exists:brands,id',
        ]);
        try {
            $brand = Brand::findOrFail($request->brand);
            $brand_merchants = $brand->merchantList();
            $merchants = Merchant::orderBy('merchant')->get();
            return view('admin.brand-merchants.all_edit', compact('brand_merchants', 'brand', 'merchants'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
    }

    public function update_all(Request $request)
    {
        $request->validate([
            'brand' => 'required|exists:brands,id',
            'merchants' => 'nullable|array',
        ]);

        try {
            $brand = Brand::findOrFail($request->brand);
            $brand->merchant = $request->input('merchants', []);
            $brand->save();
            return redirect()->route('admin.brands.index')->with('success', 'Merchants Updated Successfully');
        } catch (\Throwable $th) {
            Log::error('Brand Merchants Updated Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $brand = Brand::has('order')->find($id);
            if (is_null($brand)) {
                $brand = Brand::find($id);
                $brand->delete();
                return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully');
            } else {
                return redirect()->route('admin.brands.index')->with('error', 'You cannot delete a brand that has orders');
            }
        } catch (\Throwable $th) {
            Log::error('Brand Deleted Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
    }
}
