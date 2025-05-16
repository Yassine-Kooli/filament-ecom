<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $paymentMethods = ['stripe', 'paypal', 'cod'];
        $paymentStatuses = ['pending', 'paid', 'failed'];
        $orderStatuses = ['new', 'processing', 'shipped', 'delivered', 'cancelled'];
        $shippingMethods = ['standard', 'express', 'next_day'];
        
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'grand_total' => $this->faker->randomFloat(2, 20, 1000),
            'payment_method' => $this->faker->randomElement($paymentMethods),
            'payment_status' => $this->faker->randomElement($paymentStatuses),
            'status' => $this->faker->randomElement($orderStatuses),
            'currency' => 'USD',
            'shipping_cost' => $this->faker->randomFloat(2, 0, 50),
            'shipping_method' => $this->faker->randomElement($shippingMethods),
            'notes' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
