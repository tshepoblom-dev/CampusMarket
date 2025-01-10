<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $locations = [
            [
                'name' => 'Bangladesh',
                'state_id' => null,
                'country_id' => null,
                'country_code' => 'bd',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Dhaka',
                'state_id' => null,
                'country_id' => 1,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mohammadpur',
                'state_id' => 1,
                'country_id' => 1,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mirpur',
                'state_id' => 2,
                'country_id' => 1,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rangpur',
                'state_id' => null,
                'country_id' => 1,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rangpur City',
                'state_id' => 6,
                'country_id' => 1,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Uttora',
                'state_id' => 6,
                'country_id' => 1,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'United States',
                'state_id' => null,
                'country_id' => null,
                'country_code' => 'en',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alabama',
                'state_id' => null,
                'country_id' => 9,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alaska',
                'state_id' => null,
                'country_id' => 9,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'California',
                'state_id' => null,
                'country_id' => 9,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Colorado',
                'state_id' => null,
                'country_id' => 9,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Florida',
                'state_id' => null,
                'country_id' => 9,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phenix City',
                'state_id' => 10,
                'country_id' => 9,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vestavia Hills',
                'state_id' => 10,
                'country_id' => 9,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Anchorage',
                'state_id' => 11,
                'country_id' => 9,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fairbanks',
                'state_id' => 11,
                'country_id' => 9,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Juneau',
                'state_id' => 11,
                'country_id' => 9,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'India',
                'state_id' => null,
                'country_id' => null,
                'country_code' => 'in',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mumbai',
                'state_id' => null,
                'country_id' => 20,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kolkata',
                'state_id' => null,
                'country_id' => 20,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Delhi',
                'state_id' => null,
                'country_id' => 20,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'South Delhi',
                'state_id' => 23,
                'country_id' => 20,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'North Delhi',
                'state_id' => 23,
                'country_id' => 20,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hawra',
                'state_id' => 22,
                'country_id' => 20,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Shiliguri',
                'state_id' => 22,
                'country_id' => 20,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mad Iland',
                'state_id' => 21,
                'country_id' => 20,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Navi Mumbai',
                'state_id' => 21,
                'country_id' => 20,
                'country_code' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        if (Location::count() == 0) {
            Location::insert($locations);
        }
    }
}
