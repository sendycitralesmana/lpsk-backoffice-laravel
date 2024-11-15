<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profile_categories')->insert([
            [
                'name' => 'Profil Lembaga',
                'slug' => 'profil-lembaga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pejabat',
                'slug' => 'pejabat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Struktur Organisasi',
                'slug' => 'struktur-organisasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Unit Kerja',
                'slug' => 'unit-kerja',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Roadmap dan Rencana Strategi',
                'slug' => 'roadmap-dan-rencana-strategi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tindak Pidana Prioritas',
                'slug' => 'tindak-pidana-prioritas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ketentuan Logo',
                'slug' => 'ketentuan-logo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
