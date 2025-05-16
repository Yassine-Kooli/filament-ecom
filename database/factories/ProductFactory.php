<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(rand(2, 5), true);
        $name = ucwords($name);

        // Generate 1-3 random image placeholders
        $images = [];
        $imageCount = rand(1, 3);
        for ($i = 0; $i < $imageCount; $i++) {
            $images[] = 'products/product_'.$this->faker->numberBetween(1, 20).'.jpg';
        }

        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'brand_id' => Brand::inRandomOrder()->first()->id ?? Brand::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'images' => $images,
            'description' => $this->faker->paragraphs(rand(3, 6), true),
            'price' => $this->faker->randomFloat(2, 9.99, 999.99),
            'is_active' => $this->faker->boolean(90),
            'is_featured' => $this->faker->boolean(20),
            'in_stock' => $this->faker->boolean(80),
            'on_sale' => $this->faker->boolean(30),
        ];
    }
}
