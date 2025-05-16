<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create storage directories if they don't exist
        Storage::makeDirectory('public/products');
        
        // Get all categories and brands
        $categories = Category::all();
        $brands = Brand::all();
        
        if ($categories->isEmpty() || $brands->isEmpty()) {
            $this->command->error('Categories and Brands must be seeded before Products');
            return;
        }
        
        // Create some predefined products for each category
        foreach ($categories as $category) {
            // Create 3-5 products per category with predefined names
            $count = rand(3, 5);
            
            for ($i = 0; $i < $count; $i++) {
                $brand = $brands->random();
                $name = $this->generateProductName($category->name, $brand->name);
                
                Product::create([
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'images' => null,
                    'description' => $this->generateProductDescription($name, $category->name, $brand->name),
                    'price' => rand(99, 1999) + 0.99,
                    'is_active' => true,
                    'is_featured' => rand(0, 10) > 8,
                    'in_stock' => true,
                    'on_sale' => rand(0, 10) > 7,
                ]);
            }
        }
        
        // Create additional random products to reach 1000 total
        $existingCount = Product::count();
        $remainingCount = 1000 - $existingCount;
        
        if ($remainingCount > 0) {
            Product::factory()->count($remainingCount)->create();
        }
    }
    
    private function generateProductName(string $category, string $brand): string
    {
        $adjectives = ['Pro', 'Ultra', 'Max', 'Elite', 'Premium', 'Advanced', 'Smart', 'Deluxe', 'Extreme', 'Plus'];
        $models = ['X', 'Z', 'S', 'A', 'E', 'M', 'T', 'V', 'G', 'P'];
        
        $numbers = [rand(1, 20), rand(100, 999)];
        $number = $numbers[rand(0, 1)];
        
        $adjective = $adjectives[rand(0, count($adjectives) - 1)];
        $model = $models[rand(0, count($models) - 1)];
        
        $formats = [
            "$brand $category $adjective",
            "$brand $adjective $category",
            "$brand $category $model$number",
            "$brand $model$number $category",
            "$brand $category $adjective $model$number",
        ];
        
        return $formats[rand(0, count($formats) - 1)];
    }
    
    private function generateProductDescription(string $name, string $category, string $brand): string
    {
        $features = [
            'High-performance',
            'Energy-efficient',
            'Sleek design',
            'Cutting-edge technology',
            'User-friendly interface',
            'Premium quality',
            'Durable construction',
            'Advanced features',
            'Innovative technology',
            'Exceptional value',
        ];
        
        $benefits = [
            'Enhances productivity',
            'Saves time and effort',
            'Provides superior performance',
            'Delivers exceptional results',
            'Offers unmatched reliability',
            'Ensures maximum comfort',
            'Guarantees satisfaction',
            'Exceeds expectations',
            'Transforms your experience',
            'Revolutionizes the way you work',
        ];
        
        $shuffledFeatures = $features;
        shuffle($shuffledFeatures);
        $selectedFeatures = array_slice($shuffledFeatures, 0, 3);
        
        $shuffledBenefits = $benefits;
        shuffle($shuffledBenefits);
        $selectedBenefits = array_slice($shuffledBenefits, 0, 2);
        
        $intro = "Introducing the $name, the latest innovation from $brand in the $category category.";
        
        $featuresText = "Key Features:\n- " . implode("\n- ", $selectedFeatures);
        
        $benefitsText = "Benefits:\n- " . implode("\n- ", $selectedBenefits);
        
        $conclusion = "Experience the difference with the $name - designed to exceed your expectations and elevate your $category experience.";
        
        return "$intro\n\n$featuresText\n\n$benefitsText\n\n$conclusion";
    }
}
