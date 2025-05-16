<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create storage directories
        Storage::deleteDirectory('public/brands');
        Storage::deleteDirectory('public/categories');
        Storage::deleteDirectory('public/products');

        Storage::makeDirectory('public/brands');
        Storage::makeDirectory('public/categories');
        Storage::makeDirectory('public/products');

        // Run seeders in the correct order to maintain relationships
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
