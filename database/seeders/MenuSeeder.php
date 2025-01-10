<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Home',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Footer Menu 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Footer Menu 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        if (Menu::count() == 0) {
            Menu::insert($menus);
        }

    }
}
