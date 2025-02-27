<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Items>
 */
class ItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::inRandomOrder()->first();
        $cost = fake()->numberBetween(500, 2000);
        
        return [
            'name' => fake()->emoji(),
            'cost' => $cost,
            'price' => $cost + fake()->numberBetween(200, 500),
            'is_active' => fake()->boolean(80), 
            'category_id' => $category->id,
        ];
    }
}
