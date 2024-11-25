<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // DB::table('applications')->insert([
        //     [
        //         'slug' => 'simpusaka',
        //         'title' => 'SIMPUSAKA',
        //         'description' => 'Sistem Informasi Perlindungan Saksi dan Korban',
        //         'cover' => '{{ asset("images/application/simpusaka.png") }}',
        //         'url' => 'https://simpusaka.lpsk.go.id/layanan-simpusaka/',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'slug' => 'fondasi',
        //         'title' => 'FONDASI',
        //         'description' => 'Tindak Lanjut Keputusan Rekomendasi',
        //         'cover' => null,
        //         'url' => 'https://layanan.lpsk.go.id/monev/',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'slug' => 'ssk',
        //         'title' => 'SSK',
        //         'description' => 'Sahabat Saksi dan Korban',
        //         'cover' => null,
        //         'url' => 'https://ssk.lpsk.go.id/',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'slug' => 'opera',
        //         'title' => 'OPERA',
        //         'description' => 'Opini Penyusunan Peraturan di Lingkungan LPSK',
        //         'cover' => null,
        //         'url' => 'https://hukum.lpsk.go.id/',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'slug' => 'jdih',
        //         'title' => 'JDIH',
        //         'description' => 'Jaringan Dokumentasi dan Informasi Hukum',
        //         'cover' => null,
        //         'url' => 'https://jdih.lpsk.go.id/',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'slug' => 'eppid',
        //         'title' => 'EPPID',
        //         'description' => 'Web Portal Keterbukaan Informasi Elektronik Lembaga Perlingkungan Saksi dan Korban',
        //         'cover' => null,
        //         'url' => 'https://eppid.lpsk.go.id/',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // ]);

    }
}
