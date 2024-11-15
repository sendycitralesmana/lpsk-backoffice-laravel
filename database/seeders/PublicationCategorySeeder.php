<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublicationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('publication_categories')->insert([
            [
                'name' => 'buku',
                'slug' => 'buku',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Buletin',
                'slug' => 'buletin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jurnal',
                'slug' => 'jurnal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Laporan',
                'slug' => 'laporan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kegiatan',
                'slug' => 'kegiatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Policy Papper',
                'slug' => 'policy-papper',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Foto',
                'slug' => 'foto',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Video',
                'slug' => 'video',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
