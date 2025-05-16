<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Check if we have users and products
        if (User::count() === 0 || Product::count() === 0) {
            $this->command->error('Users and Products must be seeded before Orders');
            return;
        }
        
        // Create 1000 orders
        Order::factory()->count(1000)->create()->each(function ($order) {
            // Create 1-5 order items for each order
            $itemCount = rand(1, 5);
            $grandTotal = 0;
            
            // Get random products, ensuring no duplicates
            $products = Product::inRandomOrder()->limit($itemCount)->get();
            
            foreach ($products as $product) {
                $quantity = rand(1, 3);
                $unitAmount = $product->price;
                $totalAmount = $unitAmount * $quantity;
                $grandTotal += $totalAmount;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_amount' => $unitAmount,
                    'total_amount' => $totalAmount,
                ]);
            }
            
            // Update the order's grand total
            $shippingCost = $order->shipping_cost;
            $order->update([
                'grand_total' => $grandTotal + $shippingCost,
            ]);
            
            // Create address for the order
            Address::factory()->create([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
            ]);
        });
    }
}
