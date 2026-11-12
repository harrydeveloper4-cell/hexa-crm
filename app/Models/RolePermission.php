<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    public $table = 'role_permissions';

    protected $fillable = ['role_id', 'permissions_id', 'is_active', 'is_deleted'];

    public function permission()
    {
        return $this->belongsTo('App\Models\Permissions', 'permissions_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }
}
