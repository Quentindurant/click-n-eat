<?php

use App\Models\Item;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** @noinspection PhpUndefinedFunctionInspection */
test('item can be created', function () {
    $restaurant = Restaurant::factory()->create();
    $category = Category::factory()->create(['restaurant_id' => $restaurant->id]);
    
    $item = Item::factory()->create(['category_id' => $category->id]);

    expect($item)->toBeInstanceOf(Item::class)
        ->and($item->category_id)->toBe($category->id);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('item has correct fillable attributes', function () {
    $item = new Item();
    
    $fillable = $item->getFillable();
    expect($fillable)->toBeArray()
        ->and($fillable)->toContain('name')
        ->and($fillable)->toContain('cost')
        ->and($fillable)->toContain('price')
        ->and($fillable)->toContain('is_active')
        ->and($fillable)->toContain('category_id')
        ->and(count($fillable))->toBe(5);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('item has correct casts', function () {
    $item = new Item();
    $casts = $item->getCasts();
    
    expect($casts)->toBeArray()
        ->and($casts)->toHaveKey('is_active')
        ->and($casts['is_active'])->toBe('boolean')
        ->and($casts)->toHaveKey('cost')
        ->and($casts['cost'])->toBe('integer')
        ->and($casts)->toHaveKey('price')
        ->and($casts['price'])->toBe('integer');
});

/** @noinspection PhpUndefinedFunctionInspection */
test('item belongs to category relationship', function () {
    $item = new Item();
    $relation = $item->category();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class)
        ->and($relation->getRelated())->toBeInstanceOf(Category::class);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('item belongs to restaurant relationship', function () {
    $item = new Item();
    $relation = $item->restaurant();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class)
        ->and($relation->getRelated())->toBeInstanceOf(Restaurant::class);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('item has many order items relationship', function () {
    $item = new Item();
    $relation = $item->orderItems();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class)
        ->and($relation->getRelated())->toBeInstanceOf(OrderItem::class);
});
