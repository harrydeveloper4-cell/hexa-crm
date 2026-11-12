<?php
namespace App\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Validator;
use Auth;

class Adminiy extends Model implements AuthenticatableContract,
AuthorizableContract,
CanResetPasswordContract
{

    use Authenticatable, Authorizable, CanResetPassword;
    /**
     * The database table used by the model.
     *
     * @var string
     */


	protected $table = 'adminiy';
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'is_active',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    /**
     * Super Admin (role id 1) always has every permission.
     */
    public function isSuperAdmin()
    {
        return (int) $this->role_id === 1;
    }

    /**
     * Check whether the admin has the given permission
     * (matched by permission id or slug).
     */
    public function has_permission($permission)
    {
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

    public function has_brand($id){
        $user = auth_staff();
        $brand = UserBrand::where("brand_id" , $id)->where("user_id" , $user->id)->first();
        if($brand){
            return true;
        }else{
            return false;
        }
    }

}
