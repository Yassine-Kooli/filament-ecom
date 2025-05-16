<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $quantity = $this->faker->numberBetween(1, 5);
        $unitAmount = $product->price;
        $totalAmount = $unitAmount * $quantity;
        
        return [
            'order_id' => Order::inRandomOrder()->first()->id ?? Order::factory(),
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_amount' => $unitAmount,
            'total_amount' => $totalAmount,
        ];
    }
}
