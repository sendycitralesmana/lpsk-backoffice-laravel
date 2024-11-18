<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('news_categories')->insert([
            [
                'name' => 'Siaran Pers',
                'slug' => 'siaran-pers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Warta Hukum',
                'slug' => 'warta-hukum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Artikel',
                'slug' => 'artikel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Informasi',
                'slug' => 'informasi',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
