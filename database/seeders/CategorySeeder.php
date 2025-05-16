<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Create storage directories if they don't exist
        Storage::makeDirectory('public/categories');

        // Predefined categories for e-commerce
        $categories = [
            'Smartphones',
            'Laptops',
            'Tablets',
            'Smartwatches',
            'Headphones',
            'Speakers',
            'Cameras',
            'Gaming',
            'Home Appliances',
            'TV & Audio',
            'Computer Accessories',
            'Wearable Tech',
            'Smart Home',
            'Office Equipment',
            'Network Devices',
        ];

        foreach ($categories as $category) {
            $slug = Str::slug($category);

            // Check if category already exists
            if (! Category::where('slug', $slug)->exists()) {
                Category::create([
                    'name' => $category,
                    'slug' => $slug,
                    'image' => null,
                    'is_active' => true,
                ]);
            }
        }

        // Count existing categories
        $existingCount = Category::count();
        $targetCount = 25; // 15 predefined + 10 random
        $remainingCount = max(0, $targetCount - $existingCount);

        // Create additional random categories if needed
        if ($remainingCount > 0) {
            Category::factory()->count($remainingCount)->create();
        }
    }
}
