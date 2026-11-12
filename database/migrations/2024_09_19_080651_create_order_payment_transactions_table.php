<?php

use App\Models\Country;
use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)
            ->constrained()
            ->cascadeOnDelete();
            $table->string('payment_id');
            $table->string('payer_id');
            $table->string('sale_currency');
            $table->integer('sale_amount');
            $table->integer('paid_amount');
            $table->integer('last_digit')->nullable();
            $table->text('response')->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('billing_address');
            $table->foreignIdFor(Country::class)
            ->constrained()
            ->cascadeOnDelete();
            $table->string('state');
            $table->string('city');
            $table->string('postalcode');
            $table->string('email');
            $table->string('billing_phonenumber');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_payment_transactions');
    }
}
