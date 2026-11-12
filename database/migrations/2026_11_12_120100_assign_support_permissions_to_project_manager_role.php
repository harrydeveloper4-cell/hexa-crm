<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Gives the "Project Manager" (support person) role access to the new
 * Clients and Invoice (Payment Link) dashboard tabs.
 */
class AssignSupportPermissionsToProjectManagerRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roleId = DB::table('roles')->where('role', 'Project Manager')->value('id');
        if (!$roleId) {
            return;
        }

        foreach (['view_assigned_client', 'view_payment_link'] as $slug) {
            $permissionId = DB::table('permissions')->where('slug', $slug)->value('id');
            if (!$permissionId) {
                continue;
            }

            $exists = DB::table('role_permissions')
                ->where('role_id', $roleId)
                ->where('permissions_id', $permissionId)
                ->exists();

            if (!$exists) {
                DB::table('role_permissions')->insert([
                    'role_id' => $roleId,
                    'permissions_id' => $permissionId,
                    'is_active' => 1,
                    'is_deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $roleId = DB::table('roles')->where('role', 'Project Manager')->value('id');
        if (!$roleId) {
            return;
        }

        $permissionIds = DB::table('permissions')
            ->whereIn('slug', ['view_assigned_client', 'view_payment_link'])
            ->pluck('id')
            ->toArray();

        DB::table('role_permissions')
            ->where('role_id', $roleId)
            ->whereIn('permissions_id', $permissionIds)
            ->delete();
    }
}
