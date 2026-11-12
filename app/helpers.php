<?php

use App\Models\Brand;
use App\Models\Currency;
use App\Models\Merchant;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

/**
 * Currently logged in staff member, resolved from either guard.
 * Admin panel uses the `adminiy` guard (adminiy table) and the portal
 * uses the `user` guard (users table).
 */
function auth_staff(){
    return Auth::guard('adminiy')->user() ?: Auth::guard('user')->user();
}

/**
 * Id of the "Client" role (used for customers in the `users` table).
 */
function client_role_id(){
    return Role::where('role', 'Client')->value('id') ?: 8;
}

/**
 * Id of the "Project Manager" role — these staff members act as support persons
 * to whom clients of new orders can be assigned.
 */
function support_role_id(){
    return Role::where('role', 'Project Manager')->value('id') ?: 4;
}

/**
 * Active merchants assigned to a brand.
 * Merchant ids are stored as JSON on the brands table (`merchant` column).
 */
function get_brand_merchants($id){

    $brand = Brand::find($id);

    if (!$brand) {
        return collect();
    }

    return $brand->merchantList()->where('status', 'active')->values();
}

/**
 * Config keys for a merchant, stored globally on the merchants table
 * (`config_keys` column). Returns a JSON string so existing callers can
 * keep using json_decode() on the result.
 */
function get_merchant_keys($brand_id,$merchant_id){

    $merchant = Merchant::find($merchant_id);

    return json_encode($merchant->config_keys ?? []);
}

function get_countries(){
 
    $countries = Currency::pluck('country')->toArray();
    
    return $countries;
}
