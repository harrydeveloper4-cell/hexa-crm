<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('merchants')->insert([
            [
                'merchant' => 'PayPal', 
                'status' => 'active'
            ],
            [
                'merchant' => 'Stripe', 
                'status' => 'active'
            ],
            [
                'merchant' => 'Square', 
                'status' => 'active'
            ],
            [
                'merchant' => 'Authorize.net', 
                'status' => 'active'
            ],
            [
                'merchant' => 'Rapyd.net', 
                'status' => 'active'
            ]
        ]);
    }
}
