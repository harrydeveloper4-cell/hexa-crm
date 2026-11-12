<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandMerchant extends Model
{
    use HasFactory;
       protected $fillable = [
        'title',
    ];

    public function brand(){
        return $this->belongsTo('App\Models\Brand','brand_id','id');
    }
}
