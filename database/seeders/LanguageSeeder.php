<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $languges = [
            [
                'name' => 'English',
                'code' => 'en',
                'rtl' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Arabic',
                'code' => 'sa',
                'rtl' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bangla',
                'code' => 'bd',
                'rtl' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];


        if(Language::count()==0){
            Language::insert($languges);
          }

    }
}
