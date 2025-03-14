<?php

use App\Models\Category;
use App\Models\Restaurant;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** @noinspection PhpUndefinedFunctionInspection */
test('category can be created', function () {
    $restaurant = Restaurant::factory()->create();
    
    $category = new Category();
    $category->name = 'Test Category';
    $category->restaurant_id = $restaurant->id;
    $category->save();

    expect($category)->toBeInstanceOf(Category::class)
        ->and($category->name)->toBe('Test Category')
        ->and($category->restaurant_id)->toBe($restaurant->id);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('category has correct fillable attributes', function () {
    $category = new Category();
    
    $fillable = $category->getFillable();
    expect($fillable)->toBeArray()
        ->and($fillable)->toContain('name')
        ->and(count($fillable))->toBe(1);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('category belongs to restaurant relationship', function () {
    $category = new Category();
    $relation = $category->restaurant();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class)
        ->and($relation->getRelated())->toBeInstanceOf(Restaurant::class);
});

/** @noinspection PhpUndefinedFunctionInspection */
test('category has many items relationship', function () {
    $category = new Category();
    $relation = $category->items();
    
    expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class)
        ->and($relation->getRelated())->toBeInstanceOf(Item::class);
});
