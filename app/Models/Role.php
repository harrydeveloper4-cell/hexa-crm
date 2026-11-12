<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['role'];

    /**
     * Admin panel users that belong to this role.
     */
    public function adminiy()
    {
        return $this->hasMany('App\Models\Adminiy', 'role_id', 'id');
    }

    /**
     * Permissions assigned to this role.
     */
    public function permissions()
    {
        return $this->belongsToMany(
            'App\Models\Permissions',
            'role_permissions',
            'role_id',
            'permissions_id'
        );
    }

    public function rolePermissions()
    {
        return $this->hasMany('App\Models\RolePermission', 'role_id', 'id');
    }
}
