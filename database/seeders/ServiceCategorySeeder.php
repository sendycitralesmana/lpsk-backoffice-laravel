<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('service_categories')->insert([
            [
                'name' => 'Standar Pelayanan Pemerintah Permohonan',
                'slug' => 'standar-pelayanan-pemerintah-permohonan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Standar Pelayanan Proaktif dan Darurat',
                'slug' => 'standar-pelayanan-proaktif-dan-darurat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Standar Pelayanan Informasi Publik',
                'slug' => 'standar-pelayanan-informasi-publik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Standar Pelayanan dan Pemenuhan Hak',
                'slug' => 'standar-pelayanan-dan-pemenuhan-hak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Standar Pelayanan Penerimaan Permohonan',
                'slug' => 'standar-pelayanan-penerimaan-permohonan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
