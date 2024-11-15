<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HighlightCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('news_categories')->insert([
            [
                'name' => 'Carousel',
                'slug' => 'carousel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Modal',
                'slug' => 'modal',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
