<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeUserBrandsUserIdForeignToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Staff/customers are now stored in the `users` table, so the
        // foreign key must reference `users` instead of the legacy `adminiy`
        // table. First remove rows that only referenced `adminiy` ids.
        DB::table('user_brands')
            ->whereNotIn('user_id', function ($query) {
                $query->select('id')->from('users');
            })
            ->delete();

        Schema::table('user_brands', function (Blueprint $table) {
            $table->dropForeign('user_brands_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_brands', function (Blueprint $table) {
            $table->dropForeign('user_brands_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('adminiy')->cascadeOnDelete();
        });
    }
}
