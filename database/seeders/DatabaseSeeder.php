<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Restaurant;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Item;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Restaurant::factory()->create([
        //     'name' => 'Test Restaurant',
        // ]);

        Restaurant::factory(10)->create();
        Category::factory(10)->create();
        Item::factory(10)->create();
    }
}
