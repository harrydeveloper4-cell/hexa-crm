<?php

use App\Models\Merchant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('payment_type');
            $table->string('order_number')->nullable();
            $table->double('sale_amount');
            $table->string('sale_currency');
            $table->text('description');
            $table->string('brand_name');
            $table->string('payment_gateway');
            $table->foreignIdFor(Merchant::class)
            ->constrained()
            ->cascadeOnDelete();
            $table->string('sales_email');
            $table->string('customer_email');
            $table->enum('status',['pending','processed','completed','discarded']);
            $table->enum('payment_status',['unpaid','paid']);
            $table->text('payment_link')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->text('signature')->nullable();
            $table->text('pdf_agreement')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
