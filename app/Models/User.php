<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
     protected $fillable = ['role_id','firstname','lastname','billing_address','country','state','city','postalcode','email','billing_phonenumber', 'password', 'is_active'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    public function card_details(){
        return $this->belongsTo('App\Models\CardDetail','customer_email','email');
    }
    
    public function has_permission($permission){
        if ($this->isSuperAdmin()) {
            return true;
        }

        $role = $this->role;
        if (empty($role)) {
            return false;
        }

        return $role->permissions()
            ->where(function ($query) use ($permission) {
                $query->where('permissions.slug', $permission);
                if (is_numeric($permission)) {
                    $query->orWhere('permissions.id', $permission);
                }
            })
            ->exists();
    }

    public function isSuperAdmin(){
        return (int) $this->role_id === 1;
    }

    public function has_brand($id){
        return UserBrand::where('brand_id', $id)->where('user_id', $this->id)->exists();
    }
    
    public function role(){
        return $this->belongsTo('App\Models\Role','role_id','id');
    }

    public function brand(){
        return $this->belongsToMany('App\Models\Brand','user_brands','user_id','brand_id');
    }

    
}
