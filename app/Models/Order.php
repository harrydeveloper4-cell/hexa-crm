<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['payment_type','order_number','sale_amount','sale_currency','description','brand_name','payment_gateway','merchant_id','user_id','previous_order_id','support_person_id','sales_email','customer_email','status','expires_at','signature','pdf_agreement'];

    public function order_packages(){
        return $this->hasMany('App\Models\OrderPackage','order_id','id');
    }

    public function order_payment_transactions(){
        return $this->hasMany('App\Models\OrderPaymentTransaction','order_id','id');
    }
    
    public function packages(){
        return $this->belongsToMany('App\Models\Package','order_packages','order_id','package_id');
    }
    
    public function brand_details(){
        return $this->belongsTo('App\Models\Brand','brand_name','id');
    }
    
    public function card_details(){
        return $this->belongsTo('App\Models\CardDetail','customer_email','customer_email');
    }
    
    public function user_details(){
        return $this->belongsTo('App\Models\User','customer_email','email');
    }

    /**
     * The client (users table) this order belongs to.
     */
    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    /**
     * For up-sale orders, the original order the up-sale was sold against.
     */
    public function previous_order(){
        return $this->belongsTo('App\Models\Order','previous_order_id','id');
    }

    /**
     * Support person (users table, "Project Manager" role) this order's client is assigned to.
     */
    public function support_person(){
        return $this->belongsTo('App\Models\User','support_person_id','id');
    }
}
