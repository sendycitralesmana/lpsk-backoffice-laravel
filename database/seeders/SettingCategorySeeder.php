<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SettingCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('setting_categories')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'Instansi Aparat Penegak Hukum',
                'slug' => 'instansi-aparat-penegak-hukum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Instansi Umum',
                'slug' => 'instansi-umum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Internasional',
                'slug' => 'internasional',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Kesehatan',
                'slug' => 'kesehatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Pendidikan',
                'slug' => 'pendidikan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'LSM/Pers',
                'slug' => 'lsm-pers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
