<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InformationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // insert data to information_categories table
        DB::table('information_categories')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'Kerja Sama',
                'slug' => 'kerja-sama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Pengumuman',
                'slug' => 'pengumuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
