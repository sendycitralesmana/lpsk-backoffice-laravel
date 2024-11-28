<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProfileCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profile_categories')->insert([
            [
                'id' => Str::uuid(),
                'name' => 'Profil Lembaga',
                'slug' => 'profil-lembaga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Pejabat',
                'slug' => 'pejabat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Struktur Organisasi',
                'slug' => 'struktur-organisasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Unit Kerja',
                'slug' => 'unit-kerja',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Roadmap dan Rencana Strategi',
                'slug' => 'roadmap-dan-rencana-strategi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Tindak Pidana Prioritas',
                'slug' => 'tindak-pidana-prioritas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Ketentuan Logo',
                'slug' => 'ketentuan-logo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
