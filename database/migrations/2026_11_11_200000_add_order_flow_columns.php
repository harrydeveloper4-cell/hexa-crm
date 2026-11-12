<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds the columns required by the order creation flow (New Payment + Up-Sale Payment).
 *
 * - orders.user_id           : the client (users table) the order belongs to.
 * - orders.previous_order_id : for up-sale orders, the original order they were sold against.
 * - order_payment_transactions.user_id / client_id : the paying client, kept on the payment record.
 */
class AddOrderFlowColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('merchant_id');
            }
            if (!Schema::hasColumn('orders', 'previous_order_id')) {
                $table->unsignedBigInteger('previous_order_id')->nullable()->after('user_id');
            }
        });

        Schema::table('order_payment_transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('order_payment_transactions', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('order_id');
            }
            if (!Schema::hasColumn('order_payment_transactions', 'client_id')) {
                $table->unsignedBigInteger('client_id')->nullable()->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'previous_order_id')) {
                $table->dropColumn('previous_order_id');
            }
            if (Schema::hasColumn('orders', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });

        Schema::table('order_payment_transactions', function (Blueprint $table) {
            if (Schema::hasColumn('order_payment_transactions', 'client_id')) {
                $table->dropColumn('client_id');
            }
            if (Schema::hasColumn('order_payment_transactions', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
}
