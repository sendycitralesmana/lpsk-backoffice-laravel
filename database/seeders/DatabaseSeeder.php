<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            NewsCategorySeeder::class,
            HighlightCategorySeeder::class,
            InformationCategorySeeder::class,
            SettingCategorySeeder::class,
            ProfileCategorySeeder::class,
            ServiceCategorySeeder::class,
            PublicationCategorySeeder::class,
            ApplicationCategorySeeder::class
        ]);
    }
}
