<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApplicationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('application_categories')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'Internal',
                'slug' => 'internal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'External',
                'slug' => 'external',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
