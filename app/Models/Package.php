<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    public function brand(){
        return $this->belongsTo('App\Models\Brand','brand_id','id');
    }
    
    public function orders(){
        return $this->belongsToMany('App\Models\Order','order_packages','order_id','package_id');
    }
}
