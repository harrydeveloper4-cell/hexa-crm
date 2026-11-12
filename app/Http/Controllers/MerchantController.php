<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchants = Merchant::orderBy('id', 'desc')->get();
        return view('admin.merchants.index', compact('merchants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.merchants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'merchant' => 'required',
        ]);

        try {
            $merchant = new Merchant();
            $merchant->merchant = $request->merchant;
            $merchant->status = $request->status == null ? 'inactive' : 'active';
            $merchant->config_keys = $this->config_keys($request);
            $merchant->save();
            return redirect()->route('merchant.index')->with('success', 'Merchant created successfully');
        } catch (\Throwable $th) {
            Log::error('Merchant Created Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $merchant = Merchant::find($id);
        return view('admin.merchants.edit', compact('merchant'));
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
            'merchant' => 'required',
        ]);

        try {
            $merchant = Merchant::find($id);
            $merchant->merchant = $request->merchant;
            $merchant->status = $request->status == null ? 'inactive' : 'active';
            $merchant->config_keys = $this->config_keys($request);
            $merchant->save();
            return redirect()->route('merchant.index')->with('success', 'Merchant updated successfully');
        } catch (\Throwable $th) {
            Log::error('Merchant Updated Failed', ['error' => $th->getMessage()]);
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
            Merchant::find($id)->delete();
            return redirect()->route('merchant.index')->with('success', 'Merchant deleted successfully');
        } catch (\Throwable $th) {
            Log::error('Merchant Deleted Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
        }
    }

    /**
     * Build the config_keys array from the submitted key/value rows.
     */
    private function config_keys(Request $request)
    {
        $keys = [];

        foreach ((array) $request->input('config_key', []) as $index => $key) {
            $key = trim((string) $key);

            if ($key === '') {
                continue;
            }

            $keys[$key] = $request->input('config_value.' . $index, '');
        }

        return $keys;
    }
}
