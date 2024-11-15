<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('setting_categories')->insert([
            [
                'name' => 'Instansi Aparat Penegak Hukum',
                'slug' => 'instansi-aparat-penegak-hukum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Instansi Umum',
                'slug' => 'instansi-umum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Internasional',
                'slug' => 'internasional',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kesehatan',
                'slug' => 'kesehatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pendidikan',
                'slug' => 'pendidikan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'LSM/Pers',
                'slug' => 'lsm-pers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
