<?php

use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Reservation;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** @noinspection PhpUndefinedFunctionInspection */
test('restaurant can be created', function () {
    $restaurantData = [
        'name' => 'Test Restaurant'
    ];

    $restaurant = Restaurant::create($restaurantData);

    expect($restaurant)->toBeInstanceOf(Restaurant::class)
        ->and($restaurant->name)->toBe('Test Restaurant');
});

/** @noinspection PhpUndefinedFunctionInspection */
test('restaurant has correct fillable attributes', function () {
    $restaurant = new Restaurant();
    
    $fillable = $restaurant->getFillable();
    expect($fillable)->toContain('name')
        ->and(count($fillable))->toBe(1);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('restaurant has many categories relationship', function () {
    $restaurant = new Restaurant();
    $relation = $restaurant->categories();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class)
        ->and($relation->getRelated())->toBeInstanceOf(Category::class);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('restaurant has many reservations relationship', function () {
    $restaurant = new Restaurant();
    $relation = $restaurant->reservations();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class)
        ->and($relation->getRelated())->toBeInstanceOf(Reservation::class);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('restaurant has many orders relationship', function () {
    $restaurant = new Restaurant();
    $relation = $restaurant->orders();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class)
        ->and($relation->getRelated())->toBeInstanceOf(Order::class);
});
