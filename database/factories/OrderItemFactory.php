<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $unitPrice = fake()->randomFloat(2, 5, 50);
        $quantity = fake()->numberBetween(1, 5);
        
        return [
            'order_id' => Order::factory(),
            'item_id' => function () {
                // Utilise la factory ItemsFactory mais pour le modèle Item
                return \App\Models\Item::factory()->create()->id;
            },
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'subtotal' => $unitPrice * $quantity,
            'special_instructions' => fake()->optional(0.3)->sentence(),
        ];
    }
}
