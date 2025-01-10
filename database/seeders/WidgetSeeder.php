<?php

namespace Database\Seeders;

use App\Models\Widget;
use Illuminate\Database\Seeder;

class WidgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $widgets = [
            [
                'widget_name' => 'About Us',
                'widget_slug' => 'about-content',
                'icon' => '<i class="bi bi-file-person"></i>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'widget_name' => 'Sliders',
                'widget_slug' => 'sliders',
                'icon' => '<i class="bi bi-sliders"></i>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'widget_name' => 'Categories',
                'widget_slug' => 'categories',
                'icon' => '<i class="bi bi-list"></i>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'widget_name' => 'Latest Product',
                'widget_slug' => 'latest-product',
                'icon' => '<i class="bi bi-map"></i>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'widget_name' => 'Up Coming',
                'widget_slug' => 'up-coming-auctions',
                'icon' => '<i class="bi bi-calendar3"></i>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'widget_name' => 'Testimonial',
                'widget_slug' => 'testimonial',
                'icon' => '<i class="bi bi-chat-right-quote"></i>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'widget_name' => 'Latest Blog',
                'widget_slug' => 'our-recent-news',
                'icon' => '<i class="bi bi-newspaper"></i>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'widget_name' => 'Fun Facts',
                'widget_slug' => 'fun-facts',
                'icon' => '<i class="bi bi-emoji-smile"></i>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'widget_name' => 'Why Choose Us',
                'widget_slug' => 'features',
                'icon' => '<i class="bi bi-star"></i>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'widget_name' => 'Procedures',
                'widget_slug' => 'procedures',
                'icon' => '<i class="bi bi-bar-chart-steps"></i>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'widget_name' => 'Blogs',
                'widget_slug' => 'blogs',
                'icon' => '<i class="bi bi-newspaper"></i>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'widget_name' => 'Faq',
                'widget_slug' => 'faq',
                'icon' => '<i class="bi bi-question-square"></i>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'widget_name' => 'Code Editor',
                'widget_slug' => 'code-editor',
                'icon' => '<i class="bi bi-code"></i>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'widget_name' => 'Contact Us',
                'widget_slug' => 'contact-us',
                'icon' => '<i class="bi bi-telephone"></i>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'widget_name' => 'All Store',
                'widget_slug' => 'all-store',
                'icon' => '<i class="bi bi-telephone"></i>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'widget_name' => 'All Product',
                'widget_slug' => 'all-product',
                'icon' => '<i class="bi bi-telephone"></i>',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        if (Widget::count() == 0) {
            Widget::insert($widgets);
        }

    }
}
