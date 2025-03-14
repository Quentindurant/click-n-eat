<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $restaurant = Restaurant::factory()->create();
        
        return [
            'user_id' => $user->id,
            'restaurant_id' => $restaurant->id,
            'status' => fake()->randomElement(['pending', 'confirmed', 'completed', 'cancelled']),
            'total_amount' => fake()->randomFloat(2, 10, 200),
            'pickup_time' => fake()->dateTimeBetween('now', '+2 days'),
            'notes' => fake()->optional(0.7)->sentence(),
        ];
    }
}
