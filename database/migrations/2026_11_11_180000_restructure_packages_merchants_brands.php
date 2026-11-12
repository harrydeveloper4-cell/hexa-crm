<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RestructurePackagesMerchantsBrands extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Packages become global (name + image) instead of belonging to a brand.
        Schema::table('packages', function (Blueprint $table) {
            $table->string('img')->nullable();
        });

        try {
            Schema::table('packages', function (Blueprint $table) {
                $table->dropForeign(['brand_id']);
            });
        } catch (\Throwable $th) {
            // foreign key already removed
        }

        DB::statement('ALTER TABLE `packages` MODIFY `brand_id` BIGINT UNSIGNED NULL');

        // Merchant config keys are stored on the merchant itself now.
        DB::statement('ALTER TABLE `merchants` MODIFY `config_keys` TEXT NULL');

        // Brands keep the assigned package / merchant ids as JSON.
        Schema::table('brands', function (Blueprint $table) {
            $table->json('packages')->nullable();
            $table->json('merchant')->nullable();
        });

        // ---- migrate existing data ----

        $brandPackages = [];
        foreach (DB::table('packages')->whereNotNull('brand_id')->get() as $package) {
            $brandPackages[$package->brand_id][] = $package->id;
        }
        foreach ($brandPackages as $brandId => $ids) {
            DB::table('brands')->where('id', $brandId)
                ->update(['packages' => json_encode(array_values(array_unique($ids)))]);
        }

        $brandMerchants = [];
        foreach (DB::table('brand_merchants')->get() as $brandMerchant) {
            $brandMerchants[$brandMerchant->brand_id][] = $brandMerchant->merchant_id;

            if (!empty($brandMerchant->config_keys)) {
                $existing = DB::table('merchants')->where('id', $brandMerchant->merchant_id)->value('config_keys');
                if (empty($existing)) {
                    DB::table('merchants')->where('id', $brandMerchant->merchant_id)
                        ->update(['config_keys' => $brandMerchant->config_keys]);
                }
            }
        }
        foreach ($brandMerchants as $brandId => $ids) {
            DB::table('brands')->where('id', $brandId)
                ->update(['merchant' => json_encode(array_values(array_unique($ids)))]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['packages', 'merchant']);
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('img');
        });
    }
}
