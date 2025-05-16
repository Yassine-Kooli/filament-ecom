<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        // Create storage directories if they don't exist
        Storage::makeDirectory('public/brands');

        // Predefined brands for e-commerce
        $brands = [
            'Apple',
            'Samsung',
            'Sony',
            'LG',
            'Dell',
            'HP',
            'Lenovo',
            'Asus',
            'Acer',
            'Microsoft',
            'Google',
            'Huawei',
            'Xiaomi',
            'OnePlus',
            'Bose',
            'JBL',
            'Canon',
            'Nikon',
            'Philips',
            'Panasonic',
        ];

        foreach ($brands as $brand) {
            $slug = Str::slug($brand);

            // Check if brand already exists
            if (! Brand::where('slug', $slug)->exists()) {
                Brand::create([
                    'name' => $brand,
                    'slug' => $slug,
                    'image' => null,
                    'is_active' => true,
                ]);
            }
        }

        // Count existing brands
        $existingCount = Brand::count();
        $targetCount = 35; // 20 predefined + 15 random
        $remainingCount = max(0, $targetCount - $existingCount);

        // Create additional random brands if needed
        if ($remainingCount > 0) {
            Brand::factory()->count($remainingCount)->create();
        }
    }
}
