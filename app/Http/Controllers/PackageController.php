<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Brand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{
    public function index()
    {
        try {
            $packages = Package::where('is_deleted', '0')->orderBy('id', 'desc')->get();
            return view('admin.packages.index', compact('packages'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('admin.packages.create');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_name' => 'required',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,bmp',
        ]);

        try {
            $package = new Package();
            $package->package_name = $request->package_name;
            $package->img = $this->store_image($request);
            $package->status = 'active';
            $package->save();

            return redirect()->route('packages')->with('success', 'Package created successfully');
        } catch (\Throwable $th) {
            Log::error('Package Created Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
    }

    public function edit($id)
    {
        $package = Package::find($id);
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'package_name' => 'required',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,bmp',
        ]);

        try {
            $package = Package::find($id);
            $package->package_name = $request->package_name;
            $package->status = $request->status == null ? 'inactive' : 'active';

            if ($request->hasFile('img')) {
                if (!empty($package->img) && File::exists(public_path($package->img))) {
                    File::delete(public_path($package->img));
                }
                $package->img = $this->store_image($request);
            }

            $package->save();
            return redirect()->route('packages')->with('success', 'Package updated successfully');
        } catch (\Throwable $th) {
            Log::error('Package Updated Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        $package = Package::find($id);
        if ($package) {
            $package->is_deleted = '1';
            $package->save();
            session()->flash('success', 'package deleted successfully..!');
        } else {
            session()->flash('error', 'package deleting failed..!');
        }
        return redirect()->route('packages');
    }

    public function brand_packages_edit(Request $request)
    {
        $request->validate([
            'brand' => 'required|exists:brands,id',
        ]);
        try {
            $brand = Brand::findOrFail($request->brand);
            $brand_packages = $brand->packageList();
            $packages = Package::where('is_deleted', '0')->get();
            return view('admin.packages.all_edit', compact('brand', 'brand_packages', 'packages'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
    }

    public function update_all(Request $request)
    {
        $request->validate([
            'brand' => 'required|exists:brands,id',
            'packages' => 'nullable|array',
        ]);

        try {
            $brand = Brand::findOrFail($request->brand);
            $brand->packages = $request->input('packages', []);
            $brand->save();
            return redirect()->route('admin.brands.index')->with('success', 'Packages Updated Successfully');
        } catch (\Throwable $th) {
            Log::error('Brand Packages Updated Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
    }

    public function package_status_change($id)
    {
        $package = Package::where('id', $id)->update(['status' => request()->status]);
        if ($package) {
            return response()->json(['success' => 'Package status updated successfully'], 200);
        }
        return response()->json(['error' => 'Package status updated failed'], 404);
    }

    private function store_image(Request $request)
    {
        if (!$request->hasFile('img')) {
            return null;
        }

        $path = public_path('package_uploads');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $image = $request->file('img');
        $name = time() . '_package.' . $image->getClientOriginalExtension();
        $image->move($path, $name);

        return 'package_uploads/' . $name;
    }
}
