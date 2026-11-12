<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Seed the roles, permissions and role -> permission mapping.
     *
     * @return void
     */
    public function run()
    {
        // Roles (id => name). Super Admin must stay id 1 as it is treated
        // as "full access" across the admin panel. Client (id 8) is the
        // customer role used by the `users` table.
        $roles = [
            1 => 'Super Admin',
            2 => 'Admin',
            3 => 'Front Saler',
            4 => 'Upsaler',
            5 => 'Project Manager',
            6 => 'Team Lead',
            7 => 'Developer',
            8 => 'Client',
        ];

        // Permissions (id => [name, slug]).
        $permissions = [
            1  => ['Create User', 'create_user'],
            2  => ['Assign Role', 'assign_role'],
            3  => ['Assign Permission On Role', 'assign_role_permission'],
            4  => ['Brand View', 'brand_view'],
            5  => ['Brand Create', 'brand_create'],
            6  => ['Brand Edit', 'brand_edit'],
            7  => ['Packages View', 'packages_view'],
            8  => ['Packages Create', 'packages_create'],
            9  => ['Packages Edit', 'packages_edit'],
            10 => ['Merchant View', 'merchant_view'],
            11 => ['Merchant Create', 'merchant_create'],
            12 => ['Merchant Edit', 'merchant_edit'],
            13 => ['Create Payment Link', 'create_payment_link'],
            14 => ['View All Orders', 'view_all_orders'],
            15 => ['View Own Orders', 'view_own_orders'],
            16 => ['View Transaction', 'view_transaction'],
            17 => ['View Payment Recurring', 'view_recurring'],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_permissions')->truncate();
        DB::table('user_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = now();

        foreach ($roles as $id => $name) {
            DB::table('roles')->insert([
                'id' => $id,
                'role' => $name,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        foreach ($permissions as $id => $permission) {
            DB::table('permissions')->insert([
                'id' => $id,
                'name' => $permission[0],
                'slug' => $permission[1],
                'is_active' => 1,
                'is_deleted' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $rows = [];

        // Super Admin gets every permission.
        foreach (array_keys($permissions) as $permissionId) {
            $rows[] = [
                'role_id' => 1,
                'permissions_id' => $permissionId,
                'is_active' => 1,
                'is_deleted' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Admin gets everything except assigning permissions on roles.
        foreach (array_keys($permissions) as $permissionId) {
            if ($permissionId === 3) {
                continue;
            }
            $rows[] = [
                'role_id' => 2,
                'permissions_id' => $permissionId,
                'is_active' => 1,
                'is_deleted' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('role_permissions')->insert($rows);

        // Move all existing customers (users table) to the Client role.
        DB::table('users')->update(['role_id' => 8]);
    }
}
