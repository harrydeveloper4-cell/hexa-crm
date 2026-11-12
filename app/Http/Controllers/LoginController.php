<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Auth;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        try {
            return view('admin.login');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function login_process(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        try {
            // Admin login authenticates against the `adminiy` table only.
            if (Auth::guard('adminiy')->attempt($request->only('email', 'password'))) {
                session(['auth_guard' => 'adminiy']);

                return redirect()->route('dashboard');
            }

            return redirect()->route('admin.login')
                ->with('error', 'Ooops! Invalid Email or Password')
                ->withInput();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function logout()
    {
        try {
            $wasUser = Auth::guard('user')->check();

            Auth::guard('adminiy')->logout();
            Auth::guard('user')->logout();
            session()->forget('auth_guard');

            return redirect()->route($wasUser ? 'user.login' : 'admin.login');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }
}
