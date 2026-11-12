<?php

namespace Database\Seeders;

use App\Models\Adminiy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Roles, permissions and role -> permission mapping are handled by
        // RolePermissionSeeder. Here we only create the default Super Admin.
        Adminiy::create([
            'name' => 'Admin',
            'email' => 'admin@terminalpays.com',
            'role_id' => '1',
            'password' => Hash::make ('admin@terminalpays.com'),
        ]);
    }
}
