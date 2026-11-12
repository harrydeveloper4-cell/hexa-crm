<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Adminiy;
use App\Models\CardDetail;
use App\Models\Role;
use App\Models\Permissions;
use App\Models\Brand;
use App\Models\UserBrand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
	public function index()
	{
		try {
			$users = User::with('role')->with('brand')->get();
			return view('admin.users.index', compact('users'));
		} catch (\Throwable $th) {
			return redirect()->back()->with('error', "Request :" . $th->getMessage());
			throw $th;
		}
	}

	public function create()
	{
		try {
			$roles = Role::all();
			$permissions = Permissions::all();
			$brands = Brand::all();
			return view('admin.users.create', compact('roles', 'permissions', 'brands'));
		} catch (\Throwable $th) {
			return redirect()->back()->with('error', "Request :" . $th->getMessage());
			throw $th;
		}
	}

	public function store(Request $request)
	{
		$clientRoleId = client_role_id();

		if ($request->role_id != $clientRoleId) {
			$request->validate([
				'role_id' => 'required',
				'firstname' => 'required',
				'lastname' => 'required',
				'email' => 'required|email|unique:users',
			]);
			
			try {
				$user = new User();
				$user->firstname = $request->firstname;
				$user->lastname = $request->lastname;
				$user->role_id = $request->role_id; // permissions come from the role
				$user->email = $request->email;
				$user->billing_phonenumber = $request->billing_phonenumber;
				$user->country = $request->country;
				$user->state = $request->state;
				$user->city = $request->city;
				$user->postalcode = $request->postalcode;
				$user->is_active = 1;
				$user->password = Hash::make('12345678');
				$user->save();

				if (isset($_POST['brand_id']) && count($_POST['brand_id']) > 0) {
					foreach ($_POST['brand_id'] as $brand) {
						$UserBrand = new UserBrand();
						$UserBrand->user_id = $user->id; // id of the newly created users row
						$UserBrand->brand_id = $brand;
						$UserBrand->save();
					}
				}
				
				session()->flash('success', 'User created successfully');
				return redirect()->route('users');
			} catch (\Throwable $th) {
				return redirect()->back()->with('error', "Request :" . $th->getMessage());
				throw $th;
			}
		}
		// Admin panel staff End

		// Customer (Client)
		$request->validate([
			'role_id' => 'required',
			'firstname' => 'required',
			'lastname' => 'required',
			'email' => 'required|email|unique:users',
			'billing_phonenumber' => 'required',
			'billing_address' => 'required',
			'state' => 'required',
			'city' => 'required',
			'postalcode' => 'required',
			'country' => 'required',
		]);
		try {
			$user_data = $request->except('_token');
			$user_data['role_id'] = $clientRoleId;
			$user = User::create($user_data);
			if (!empty($user)) {
				$data = $request->except('_token');
				$card_details = new CardDetail();
				$card_details->owner = $data['owner'] ?? '';
				$card_details->cardNumber = $data['cardNumber'] ?? '';
				$card_details->cvv = $data['cvv'] ?? '';
				$card_details->expiration_month = $data['expiration-month'] ?? '';
				$card_details->expiration_year = $data['expiration-year'] ?? '';
				$card_details->customer_email = $user->email;
				$card_details->merchant = '';
				$card_details->save();
				session()->flash('success', 'User created successfully');
			} else {
				session()->flash('error', 'User creating failed');
			}
			return redirect()->route('users');
		} catch (\Throwable $th) {
			return redirect()->back()->with('error', "Request :" . $th->getMessage());
			throw $th;
		}
	}

	public function show($id)
	{
		try {
			$user = User::with('brand')->find($id);
			$user_card = CardDetail::where('customer_email', $user->email)->first();
			$role = Role::where('id', $user->role_id)->first();
			return view('admin.users.show', compact('user', 'role', 'user_card'));
		} catch (\Throwable $th) {
			return redirect()->back()->with('error', "Request :" . $th->getMessage());
			throw $th;
		}
	}
	
	public function edit($id)
	{
		try {
			$user = User::with('brand')->find($id);
			$user_card = CardDetail::where('customer_email', $user->email)->first();
			$brands = Brand::all();
			$roles = Role::all();
			return view('admin.users.edit', compact('user', 'roles', 'user_card', 'brands'));
		} catch (\Throwable $th) {
			return redirect()->back()->with('error', "Request :" . $th->getMessage());
			throw $th;
		}
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'role_id' => 'required',
			'firstname' => 'required',
			'lastname' => 'required',
			'email' => 'required|email',
			'billing_phonenumber' => 'required',
			'billing_address' => 'required',
			'state' => 'required',
			'city' => 'required',
			'postalcode' => 'required',
			'country' => 'required',
			'password' => 'nullable|min:8|confirmed',
		]);
		try {
			$user = User::find($id);
			$user->role_id = $request->role_id;
			$user->firstname = $request->firstname;
			$user->lastname = $request->lastname;
			$user->email = $request->email;
			$user->billing_phonenumber = $request->billing_phonenumber;
			$user->city = $request->city;
			$user->state = $request->state;
			$user->postalcode = $request->postalcode;
			$user->country = $request->country;
			$user->billing_address = $request->billing_address;
			if ($request->filled('password')) {
				$user->password = Hash::make($request->password);
			}
			$user->save();

			// Sync the user's assigned brands (user_brands pivot).
			UserBrand::where('user_id', $user->id)->delete();
			if ($request->filled('brand_id')) {
				foreach (array_unique((array) $request->brand_id) as $brand_id) {
					$user_brand = new UserBrand();
					$user_brand->user_id = $user->id;
					$user_brand->brand_id = $brand_id;
					$user_brand->save();
				}
			}

			if (!empty($user)) {
				session()->flash('success', 'User updated successfully');
			} else {
				session()->flash('error', 'User updating failed');
			}
			return redirect()->route('users');
		} catch (\Throwable $th) {
			return redirect()->back()->with('error', "Request :" . $th->getMessage());
			throw $th;
		}
	}

	public function destroy($id)
	{
		try {
			$user = User::find($id);
			if (!empty($user)) {
				$user->delete();
				session()->flash('success', 'User deleted successfully');
			} else {
				session()->flash('success', 'User deleting failed');
			}
			return redirect()->route('users');
		} catch (\Throwable $th) {
			return redirect()->back()->with('error', "Request :" . $th->getMessage());
			throw $th;
		}
	}

	public function login()
	{
		return view('user.login');
	}

	public function login_process(Request $request)
	{
		$request->validate([
			'email' => 'required|email',
			'password' => 'required'
		]);
		try {
			// User login authenticates against the `users` table only.
			if (Auth::guard('user')->attempt($request->only('email', 'password'))) {
				session(['auth_guard' => 'user']);

				return redirect()->route('dashboard');
			}

			return redirect()->route('user.login')
				->with('error', 'Ooops! Invalid Email or Password')
				->withInput();
		} catch (\Throwable $th) {
			return redirect()->back()->with('error', "Request :" . $th->getMessage());
			throw $th;
		}
	}

	public function admins_list()
	{
		try {
			$admins = Adminiy::where('id', '!=', 1)->orderBy('id', 'DESC')->get();
			return view('admin.list.index', compact('admins'));
		} catch (\Throwable $th) {
			return redirect()->back()->with('error', "Request :" . $th->getMessage());
			throw $th;
		}
	}

	public function admin_destroy($id)
	{
		try {
			$user = Adminiy::find($id);
			if (!empty($user)) {
				$user->delete();
				session()->flash('success', 'Admin deleted successfully');
			} else {
				session()->flash('success', 'Admin deleting failed');
			}
			return redirect()->route('admins');
		} catch (\Throwable $th) {
			return redirect()->back()->with('error', "Request :" . $th->getMessage());
			throw $th;
		}
	}

	public function updateAjax(Request $request)
	{
		$admin = Adminiy::find($request->id);
		$admin->name = $request->name;
		if (!empty($request->password)) {
			$admin->password = Hash::make($request->password);
		}
		$admin->save();

		return response()->json(['message' => 'Updated successfully']);
	}

	public function statusToggle(Request $request)
	{
		$admin = Adminiy::find($request->id);
		$admin->is_active = $request->currentStatus == 1 ? 0 : 1;
		$admin->save();

		return response()->json(['status' => $admin->is_active]);
	}


}
