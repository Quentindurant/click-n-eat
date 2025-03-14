<?php

use App\Models\Reservation;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** @noinspection PhpUndefinedFunctionInspection */
test('reservation can be created', function () {
    $user = User::factory()->create();
    $restaurant = Restaurant::factory()->create();
    
    $reservationData = [
        'user_id' => $user->id,
        'restaurant_id' => $restaurant->id,
        'reservation_date' => now()->addDay(),
        'number_of_guests' => 4,
        'status' => 'confirmed',
        'special_requests' => 'Window seat please'
    ];

    $reservation = Reservation::create($reservationData);

    expect($reservation)->toBeInstanceOf(Reservation::class)
        ->and($reservation->user_id)->toBe($user->id)
        ->and($reservation->restaurant_id)->toBe($restaurant->id)
        ->and($reservation->number_of_guests)->toBe(4)
        ->and($reservation->status)->toBe('confirmed')
        ->and($reservation->special_requests)->toBe('Window seat please');
});

/** @noinspection PhpUndefinedFunctionInspection */
test('reservation has correct fillable attributes', function () {
    $reservation = new Reservation();
    
    $fillable = $reservation->getFillable();
    expect($fillable)->toBeArray()
        ->and($fillable)->toContain('user_id')
        ->and($fillable)->toContain('restaurant_id')
        ->and($fillable)->toContain('reservation_date')
        ->and($fillable)->toContain('number_of_guests')
        ->and($fillable)->toContain('status')
        ->and($fillable)->toContain('special_requests')
        ->and(count($fillable))->toBe(6);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('reservation has correct casts', function () {
    $reservation = new Reservation();
    $casts = $reservation->getCasts();
    
    expect($casts)->toBeArray()
        ->and($casts)->toHaveKey('reservation_date')
        ->and($casts['reservation_date'])->toBe('datetime')
        ->and($casts)->toHaveKey('number_of_guests')
        ->and($casts['number_of_guests'])->toBe('integer');
});

/** @noinspection PhpUndefinedFunctionInspection */
test('reservation belongs to user relationship', function () {
    $reservation = new Reservation();
    $relation = $reservation->user();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class)
        ->and($relation->getRelated())->toBeInstanceOf(User::class);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('reservation belongs to restaurant relationship', function () {
    $reservation = new Reservation();
    $relation = $reservation->restaurant();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class)
        ->and($relation->getRelated())->toBeInstanceOf(Restaurant::class);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('reservation has one order relationship', function () {
    $reservation = new Reservation();
    $relation = $reservation->order();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasOne::class)
        ->and($relation->getRelated())->toBeInstanceOf(Order::class);
});
