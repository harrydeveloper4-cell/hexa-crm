<?php

use App\Models\Brand;
use App\Models\Merchant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_merchants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Brand::class)
            ->constrained()
            ->cascadeOnDelete();
            $table->foreignIdFor(Merchant::class)
            ->constrained()
            ->cascadeOnDelete();
            $table->text('config_keys');
            $table->enum('status',['active','inactive']);
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
        Schema::dropIfExists('brand_merchants');
    }
}
