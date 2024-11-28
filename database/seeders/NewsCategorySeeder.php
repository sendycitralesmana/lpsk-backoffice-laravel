<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('news_categories')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'Siaran Pers',
                'slug' => 'siaran-pers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Warta Hukum',
                'slug' => 'warta-hukum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Artikel',
                'slug' => 'artikel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Informasi',
                'slug' => 'informasi',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
