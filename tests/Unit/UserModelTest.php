<?php

use App\Models\User;
use App\Models\Order;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;

/** @noinspection PhpUndefinedFunctionInspection */
test('user can be created', function () {
    $userData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ];

    $user = User::create($userData);

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->name)->toBe('Test User')
        ->and($user->email)->toBe('test@example.com');
});

/** @noinspection PhpUndefinedFunctionInspection */
test('user has correct fillable attributes', function () {
    $user = new User();
    
    expect($user->getFillable())->toBe([
        'name',
        'email',
        'password',
    ]);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('user has correct hidden attributes', function () {
    $user = new User();
    
    expect($user->getHidden())->toBe([
        'password',
        'remember_token',
    ]);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('user has correct casts', function () {
    $user = new User();
    $casts = $user->getCasts();
    
    expect($casts)->toHaveKey('email_verified_at')
        ->and($casts)->toHaveKey('password');
});

/** @noinspection PhpUndefinedFunctionInspection */
test('user has many orders relationship', function () {
    $user = new User();
    $relation = $user->orders();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class)
        ->and($relation->getRelated())->toBeInstanceOf(Order::class);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('user has many reservations relationship', function () {
    $user = new User();
    $relation = $user->reservations();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class)
        ->and($relation->getRelated())->toBeInstanceOf(Reservation::class);
});
