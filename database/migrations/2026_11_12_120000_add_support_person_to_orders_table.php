<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Adds support-person assignment for new orders (previous_order_id = null).
 *
 * - orders.support_person_id : the staff member (adminiy, "Project Manager" role) the client is assigned to.
 */
class AddSupportPersonToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('orders', 'support_person_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->unsignedBigInteger('support_person_id')->nullable()->after('previous_order_id');
            });
        }

        $permissions = [
            ['name' => 'Assign Support Person', 'slug' => 'assign_support_person'],
            ['name' => 'View Assigned Clients', 'slug' => 'view_assigned_client'],
            ['name' => 'View Payment Link', 'slug' => 'view_payment_link'],
        ];

        foreach ($permissions as $permission) {
            if (!DB::table('permissions')->where('slug', $permission['slug'])->exists()) {
                DB::table('permissions')->insert([
                    'name' => $permission['name'],
                    'slug' => $permission['slug'],
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
        if (Schema::hasColumn('orders', 'support_person_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('support_person_id');
            });
        }

        DB::table('permissions')
            ->whereIn('slug', ['assign_support_person', 'view_assigned_client', 'view_payment_link'])
            ->delete();
    }
}
