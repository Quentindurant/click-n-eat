<?php

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Item;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** @noinspection PhpUndefinedFunctionInspection */
test('order item can be created', function () {
    $user = User::factory()->create();
    $restaurant = Restaurant::factory()->create();
    $category = Category::factory()->create(['restaurant_id' => $restaurant->id]);
    $item = Item::factory()->create(['category_id' => $category->id]);
    $order = Order::factory()->create([
        'user_id' => $user->id,
        'restaurant_id' => $restaurant->id
    ]);
    
    $orderItemData = [
        'order_id' => $order->id,
        'item_id' => $item->id,
        'quantity' => 2,
        'unit_price' => 10.99,
        'subtotal' => 21.98,
        'special_instructions' => 'Extra spicy'
    ];

    $orderItem = OrderItem::create($orderItemData);

    expect($orderItem)->toBeInstanceOf(OrderItem::class)
        ->and($orderItem->order_id)->toEqual($order->id)
        ->and($orderItem->item_id)->toEqual($item->id)
        ->and($orderItem->quantity)->toEqual(2)
        ->and($orderItem->unit_price)->toEqual(10.99)
        ->and($orderItem->subtotal)->toEqual(21.98)
        ->and($orderItem->special_instructions)->toEqual('Extra spicy');
});

/** @noinspection PhpUndefinedFunctionInspection */
test('order item has correct attributes', function () {
    $user = User::factory()->create();
    $restaurant = Restaurant::factory()->create();
    $category = Category::factory()->create(['restaurant_id' => $restaurant->id]);
    $item = Item::factory()->create(['category_id' => $category->id]);
    $order = Order::factory()->create([
        'user_id' => $user->id,
        'restaurant_id' => $restaurant->id,
    ]);
    
    $orderItem = new OrderItem();
    $orderItem->order_id = $order->id;
    $orderItem->item_id = $item->id;
    $orderItem->quantity = 2;
    $orderItem->unit_price = 10.99;
    $orderItem->subtotal = 21.98;
    $orderItem->special_instructions = 'Extra spicy';
    $orderItem->save();
    
    expect($orderItem)->toBeInstanceOf(OrderItem::class)
        ->and($orderItem->order_id)->toEqual($order->id)
        ->and($orderItem->item_id)->toEqual($item->id)
        ->and($orderItem->quantity)->toEqual(2)
        ->and($orderItem->unit_price)->toEqual(10.99)
        ->and($orderItem->subtotal)->toEqual(21.98)
        ->and($orderItem->special_instructions)->toEqual('Extra spicy');
});

/** @noinspection PhpUndefinedFunctionInspection */
test('order item has correct fillable attributes', function () {
    $orderItem = new OrderItem();
    
    $fillable = $orderItem->getFillable();
    expect($fillable)->toBeArray()
        ->and($fillable)->toContain('order_id')
        ->and($fillable)->toContain('item_id')
        ->and($fillable)->toContain('quantity')
        ->and($fillable)->toContain('unit_price')
        ->and($fillable)->toContain('subtotal')
        ->and($fillable)->toContain('special_instructions')
        ->and(count($fillable))->toBe(6);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('order item has correct casts', function () {
    $orderItem = new OrderItem();
    $casts = $orderItem->getCasts();
    
    expect($casts)->toBeArray()
        ->and($casts)->toHaveKey('quantity')
        ->and($casts['quantity'])->toBe('integer')
        ->and($casts)->toHaveKey('unit_price')
        ->and($casts['unit_price'])->toBe('decimal:2')
        ->and($casts)->toHaveKey('subtotal')
        ->and($casts['subtotal'])->toBe('decimal:2');
});

/** @noinspection PhpUndefinedFunctionInspection */
test('order item belongs to order relationship', function () {
    $orderItem = new OrderItem();
    $relation = $orderItem->order();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class)
        ->and($relation->getRelated())->toBeInstanceOf(Order::class);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('order item belongs to item relationship', function () {
    $orderItem = new OrderItem();
    $relation = $orderItem->item();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class)
        ->and($relation->getRelated())->toBeInstanceOf(Item::class);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('order item can calculate subtotal', function () {
    $user = User::factory()->create();
    $restaurant = Restaurant::factory()->create();
    $category = Category::factory()->create(['restaurant_id' => $restaurant->id]);
    $item = Item::factory()->create(['category_id' => $category->id]);
    
    $order = new Order();
    $order->user_id = $user->id;
    $order->restaurant_id = $restaurant->id;
    $order->total_amount = 0;
    $order->save();
    
    $orderItem = new OrderItem();
    $orderItem->order_id = $order->id;
    $orderItem->item_id = $item->id;
    $orderItem->quantity = 3;
    $orderItem->unit_price = 15.50;
    $orderItem->subtotal = 0;
    $orderItem->save();
    
    // Refresh the order item to ensure relationships are loaded
    $orderItem->refresh();
    
    $subtotal = $orderItem->calculateSubtotal();
    
    // Refresh to get the updated values
    $orderItem->refresh();
    
    // Check that the subtotal is calculated correctly (3 * 15.50 = 46.50)
    expect(round($orderItem->subtotal, 2))->toEqual(46.50);
    
    // Check that the returned value is correct
    expect(round($subtotal, 2))->toEqual(46.50);
});
