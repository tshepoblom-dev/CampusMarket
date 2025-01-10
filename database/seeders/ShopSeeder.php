<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $shops = [

            [
                'name' => 'Egens',
                'slug' => 'egens',
                'author_id' => 2,
                'email' => 'test2@gmail.com',
                'phone' => '01711454988',
                'address' => 'Block A, House 82 Rd No 2',
                'logo' => 'erezon_fb-1698075694.png',
                'cover_img' => 'Untitled design (3)-1681895266-1698075694.png',
                'facebook' => '#',
                'twitter' => '#',
                'linkedin' => '#',
                'instagram' => '#',
                'pinterest' => '#',
                'youtube' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        if (Store::count() == 0) {
            Store::insert($shops);
        }

    }
}
