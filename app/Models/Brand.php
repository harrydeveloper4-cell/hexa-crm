<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $casts = [
        'packages' => 'array',
        'merchant' => 'array',
    ];

    /**
     * Packages assigned to this brand (ids stored as JSON on the brand).
     */
    public function packageList()
    {
        $ids = $this->packages ?? [];

        if (empty($ids)) {
            return Package::whereRaw('1 = 0')->get();
        }

        return Package::whereIn('id', $ids)->where('is_deleted', '0')->get();
    }

    /**
     * Merchants assigned to this brand (ids stored as JSON on the brand).
     */
    public function merchantList()
    {
        $ids = $this->merchant ?? [];

        if (empty($ids)) {
            return Merchant::whereRaw('1 = 0')->get();
        }

        return Merchant::whereIn('id', $ids)->get();
    }

    public function order(){
        return $this->hasMany('App\Models\Order','brand_name','id');
    }
}
