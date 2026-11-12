<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['order_id','user_id','client_id','payment_id','payer_id','sale_currency','sale_amount','paid_amount','last_digit','response','firstname','lastname','billing_address','country','state','city','postalcode','email','billing_phonenumber'];

    public function orders(){
        return $this->belongsTo('App\Models\Order','order_id','id');
    }
    public function getCountry(){
        return $this->belongsTo('App\Models\Country','country','id');
    }
}
