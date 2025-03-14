<?php

use App\Models\Order;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Reservation;
use App\Models\OrderItem;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** @noinspection PhpUndefinedFunctionInspection */
test('order can be created', function () {
    $user = User::factory()->create();
    $restaurant = Restaurant::factory()->create();
    $reservation = Reservation::factory()->create([
        'user_id' => $user->id,
        'restaurant_id' => $restaurant->id
    ]);
    
    $orderData = [
        'user_id' => $user->id,
        'restaurant_id' => $restaurant->id,
        'reservation_id' => $reservation->id,
        'status' => 'pending',
        'total_amount' => 0,
        'pickup_time' => now()->addHour(),
        'notes' => 'Test notes'
    ];

    $order = Order::create($orderData);

    expect($order)->toBeInstanceOf(Order::class)
        ->and($order->user_id)->toBe($user->id)
        ->and($order->restaurant_id)->toBe($restaurant->id)
        ->and($order->reservation_id)->toBe($reservation->id)
        ->and($order->status)->toBe('pending')
        ->and($order->notes)->toBe('Test notes');
});

/** @noinspection PhpUndefinedFunctionInspection */
test('order has correct fillable attributes', function () {
    $order = new Order();
    
    $fillable = $order->getFillable();
    expect($fillable)->toBeArray()
        ->and($fillable)->toContain('user_id')
        ->and($fillable)->toContain('restaurant_id')
        ->and($fillable)->toContain('reservation_id')
        ->and($fillable)->toContain('status')
        ->and($fillable)->toContain('total_amount')
        ->and($fillable)->toContain('pickup_time')
        ->and($fillable)->toContain('notes')
        ->and(count($fillable))->toBe(7);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('order has correct casts', function () {
    $order = new Order();
    $casts = $order->getCasts();
    
    expect($casts)->toBeArray()
        ->and($casts)->toHaveKey('total_amount')
        ->and($casts['total_amount'])->toBe('decimal:2')
        ->and($casts)->toHaveKey('pickup_time')
        ->and($casts['pickup_time'])->toBe('datetime');
});

/** @noinspection PhpUndefinedFunctionInspection */
test('order belongs to user relationship', function () {
    $order = new Order();
    $relation = $order->user();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class)
        ->and($relation->getRelated())->toBeInstanceOf(User::class);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('order belongs to restaurant relationship', function () {
    $order = new Order();
    $relation = $order->restaurant();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class)
        ->and($relation->getRelated())->toBeInstanceOf(Restaurant::class);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('order belongs to reservation relationship', function () {
    $order = new Order();
    $relation = $order->reservation();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class)
        ->and($relation->getRelated())->toBeInstanceOf(Reservation::class);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('order has many items relationship', function () {
    $order = new Order();
    $relation = $order->items();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class)
        ->and($relation->getRelated())->toBeInstanceOf(OrderItem::class);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('order can calculate total', function () {
    $user = User::factory()->create();
    $restaurant = Restaurant::factory()->create();
    
    $order = new Order();
    $order->user_id = $user->id;
    $order->restaurant_id = $restaurant->id;
    $order->status = 'pending';
    $order->total_amount = 0;
    $order->save();
    
    $category = Category::factory()->create([
        'restaurant_id' => $restaurant->id
    ]);
    
    $item1 = Item::factory()->create([
        'category_id' => $category->id,
        'price' => 1000
    ]);
    
    $item2 = Item::factory()->create([
        'category_id' => $category->id,
        'price' => 2000
    ]);
    
    // Create order items
    $orderItem1 = new OrderItem();
    $orderItem1->order_id = $order->id;
    $orderItem1->item_id = $item1->id;
    $orderItem1->quantity = 2;
    $orderItem1->unit_price = 10.00;
    $orderItem1->subtotal = 20.00;
    $orderItem1->save();
    
    $orderItem2 = new OrderItem();
    $orderItem2->order_id = $order->id;
    $orderItem2->item_id = $item2->id;
    $orderItem2->quantity = 1;
    $orderItem2->unit_price = 20.00;
    $orderItem2->subtotal = 20.00;
    $orderItem2->save();
    
    // Refresh the order to load the items relationship
    $order->refresh();
    
    $total = $order->calculateTotal();
    
    // Refresh the order to get the updated total_amount
    $order->refresh();
    
    // Check the returned value and the updated model attribute
    expect($total)->toEqual(40.00);
    expect($order->total_amount)->toEqual(40.00);
});
