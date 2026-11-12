<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency')->insert([
            ['country' => 'Albania', 'currency' => 'Leke', 'code' => 'ALL', 'symbol' => 'Lek'],
            ['country' => 'Afghanistan', 'currency' => 'Afghanis', 'code' => 'AFN', 'symbol' => '؋'],
            ['country' => 'Argentina', 'currency' => 'Pesos', 'code' => 'ARS', 'symbol' => '$'],
            ['country' => 'Aruba', 'currency' => 'Guilders', 'code' => 'AWG', 'symbol' => 'ƒ'],
            ['country' => 'Australia', 'currency' => 'Dollars', 'code' => 'AUD', 'symbol' => '$'],
            ['country' => 'Azerbaijan', 'currency' => 'New Manats', 'code' => 'AZN', 'symbol' => '₼'],
            ['country' => 'Bahamas', 'currency' => 'Dollars', 'code' => 'BSD', 'symbol' => '$'],
            ['country' => 'Barbados', 'currency' => 'Dollars', 'code' => 'BBD', 'symbol' => '$'],
            ['country' => 'Belarus', 'currency' => 'Rubles', 'code' => 'BYR', 'symbol' => 'p.'],
            ['country' => 'Belgium', 'currency' => 'Euro', 'code' => 'EUR', 'symbol' => '€'],
            ['country' => 'Beliz', 'currency' => 'Dollars', 'code' => 'BZD', 'symbol' => 'BZ$'],
            ['country' => 'Bermuda', 'currency' => 'Dollars', 'code' => 'BMD', 'symbol' => '$'],
            ['country' => 'Bolivia', 'currency' => 'Bolivianos', 'code' => 'BOB', 'symbol' => '$b'],
            ['country' => 'Bosnia and Herzegovina', 'currency' => 'Convertible Marka', 'code' => 'BAM', 'symbol' => 'KM'],
            ['country' => 'Botswana', 'currency' => 'Pula', 'code' => 'BWP', 'symbol' => 'P'],
            ['country' => 'Bulgaria', 'currency' => 'Leva', 'code' => 'BGN', 'symbol' => 'лв'],
            ['country' => 'Brazil', 'currency' => 'Reais', 'code' => 'BRL', 'symbol' => 'R$'],
            ['country' => 'Brunei Darussalam', 'currency' => 'Dollars', 'code' => 'BND', 'symbol' => '$'],
            ['country' => 'Cambodia', 'currency' => 'Riels', 'code' => 'KHR', 'symbol' => '៛'],
            ['country' => 'Canada', 'currency' => 'Dollars', 'code' => 'CAD', 'symbol' => '$'],
            ['country' => 'Cayman Islands', 'currency' => 'Dollars', 'code' => 'KYD', 'symbol' => '$'],
            ['country' => 'Chile', 'currency' => 'Pesos', 'code' => 'CLP', 'symbol' => '$'],
            ['country' => 'China', 'currency' => 'Yuan Renminbi', 'code' => 'CNY', 'symbol' => '¥'],
            ['country' => 'Colombia', 'currency' => 'Pesos', 'code' => 'COP', 'symbol' => '$'],
            ['country' => 'Costa Rica', 'currency' => 'Colón', 'code' => 'CRC', 'symbol' => '₡'],
            ['country' => 'United States', 'currency' => 'Dollars', 'code' => 'USD', 'symbol' => '$']
        ]);
    }
}
