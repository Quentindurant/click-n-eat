<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RestaurantsController;
use App\Http\Controllers\ItemsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('categories.index');
});

Route::get('/restaurants', [RestaurantsController::class, 'index'])->name('restaurants.index');
Route::get('/restaurants/{id}/show', [RestaurantsController::class, 'show'])->name('restaurants.show');
Route::get('/restaurants/create', [RestaurantsController::class, 'create'])->name('restaurants.create');
Route::post('/restaurants', [RestaurantsController::class, 'store'])->name('restaurants.store');
Route::get('/restaurants/{id}/edit', [RestaurantsController::class, 'edit'])->name('restaurants.edit');
Route::put('/restaurants/{id}/update', [RestaurantsController::class, 'update'])->name('restaurants.update');
Route::delete('/restaurants/{id}/destroy', [RestaurantsController::class, 'destroy'])->name('restaurants.destroy');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}/show', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

Route::get('/items', [ItemsController::class, 'index'])->name('items.index');
Route::get('/items/{id}/show', [ItemsController::class, 'show'])->name('items.show');
Route::get('/items/create', [ItemsController::class, 'create'])->name('items.create');
Route::post('/items', [ItemsController::class, 'store'])->name('items.store');
Route::get('/items/{id}/edit', [ItemsController::class, 'edit'])->name('items.edit');
Route::put('/items/{id}', [ItemsController::class, 'update'])->name('items.update');
Route::delete('/items/{id}', [ItemsController::class, 'destroy'])->name('items.destroy');
