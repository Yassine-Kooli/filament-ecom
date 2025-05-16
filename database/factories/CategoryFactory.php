<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(rand(1, 3), true);
        $name = ucwords($name);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => 'categories/category_'.$this->faker->numberBetween(1, 10).'.jpg',
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
