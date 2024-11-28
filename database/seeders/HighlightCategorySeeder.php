<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HighlightCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('highlight_categories')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'Carousel',
                'slug' => 'carousel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Modal',
                'slug' => 'modal',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
