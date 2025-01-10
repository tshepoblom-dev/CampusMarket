<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $currencies = [
            [
                'name' => 'U.S. Dollar',
                'symbol' => '$',
                'code' => 'USD',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Australian Dollar',
                'symbol' => '$',
                'code' => 'AUD',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),

            ],

            [
                'name' => 'Brazilian Real',
                'symbol' => 'R$',
                'code' => 'BRL',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Canadian Dollar',
                'symbol' => '$',
                'code' => 'CAD',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Czech Koruna',
                'symbol' => 'Kč',
                'code' => 'CZK',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Danish Krone',
                'symbol' => 'kr',
                'code' => 'DKK',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Euro',
                'symbol' => '€',
                'code' => 'EUR',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hong Kong Dollar',
                'symbol' => '$',
                'code' => 'HKD',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hungarian Forint',
                'symbol' => 'Ft',
                'code' => 'HUF',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Israeli New Sheqel',
                'symbol' => '₪',
                'code' => 'ILS',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Japanese Yen',
                'symbol' => '¥',
                'code' => 'JPY',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Malaysian Ringgit',
                'symbol' => 'RM',
                'code' => 'MYR',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mexican Peso',
                'symbol' => '$',
                'code' => 'MXN',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Norwegian Krone',
                'symbol' => 'kr',
                'code' => 'NOK',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'New Zealand Dollar',
                'symbol' => '$',
                'code' => 'NZD',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Philippine Peso',
                'symbol' => '₱',
                'code' => 'PHP',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Polish Zloty',
                'symbol' => 'zł',
                'code' => 'PLN',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pound Sterling',
                'symbol' => '£',
                'code' => 'GBP',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Russian Ruble',
                'symbol' => 'руб',
                'code' => 'RUB',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Singapore Dollar',
                'symbol' => '$',
                'code' => 'SGD',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Swedish Krona',
                'symbol' => 'kr',
                'code' => 'SEK',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Swiss Franc',
                'symbol' => 'CHF',
                'code' => 'CHF',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thai Baht',
                'symbol' => '฿',
                'code' => 'THB',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bangladeshi Taka',
                'symbol' => '৳',
                'code' => 'BDT',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Indian Rupee',
                'symbol' => 'Rs',
                'code' => 'Rupee',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];


        if(Currency::count()==0){
            Currency::insert($currencies);
          }

    }
}
