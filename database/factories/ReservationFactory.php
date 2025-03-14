<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'restaurant_id' => Restaurant::factory(),
            'reservation_date' => fake()->dateTimeBetween('now', '+7 days'),
            'number_of_guests' => fake()->numberBetween(1, 10),
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled']),
            'special_requests' => fake()->optional(0.5)->sentence(),
        ];
    }
}
