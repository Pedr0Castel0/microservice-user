<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DishController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentMethodController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('api.auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
        Route::get('/user', [AuthController::class, 'user'])->name('api.auth.user');
    });
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('api.categories.index');
    Route::get('/{category}', [CategoryController::class, 'show'])->name('api.categories.show');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [CategoryController::class, 'store'])->name('api.categories.store');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('api.categories.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('api.categories.destroy');
    });
});

Route::prefix('dishes')->group(function () {
    Route::get('/', [DishController::class, 'index'])->name('api.dishes.index');
    Route::get('/available', [DishController::class, 'available'])->name('api.dishes.available');
    Route::get('/featured', [DishController::class, 'featured'])->name('api.dishes.featured');
    Route::get('/popular', [DishController::class, 'popular'])->name('api.dishes.popular');
    Route::get('/spice-levels', [DishController::class, 'spiceLevels'])->name('api.dishes.spice-levels');
    Route::get('/statistics', [DishController::class, 'statistics'])->name('api.dishes.statistics');
    Route::get('/search', [DishController::class, 'search'])->name('api.dishes.search');
    Route::get('/category/{categoryId}', [DishController::class, 'byCategory'])->name('api.dishes.by-category');
    Route::get('/spice-level/{spiceLevel}', [DishController::class, 'bySpiceLevel'])->name('api.dishes.by-spice-level');
    Route::get('/price-range', [DishController::class, 'byPriceRange'])->name('api.dishes.by-price-range');
    Route::get('/{id}', [DishController::class, 'show'])->name('api.dishes.show');
    Route::get('/{dishId}/recommendations', [DishController::class, 'recommendations'])->name('api.dishes.recommendations');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [DishController::class, 'store'])->name('api.dishes.store');
        Route::put('/{id}', [DishController::class, 'update'])->name('api.dishes.update');
        Route::delete('/{id}', [DishController::class, 'destroy'])->name('api.dishes.destroy');
        Route::patch('/{id}/toggle-availability', [DishController::class, 'toggleAvailability'])->name('api.dishes.toggle-availability');
    });
});

Route::prefix('orders')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('api.orders.index');
        Route::post('/', [OrderController::class, 'store'])->name('api.orders.store');
        Route::get('/{id}', [OrderController::class, 'show'])->name('api.orders.show');
        Route::put('/{id}', [OrderController::class, 'update'])->name('api.orders.update');
        Route::delete('/{id}', [OrderController::class, 'destroy'])->name('api.orders.destroy');
        Route::patch('/{id}/status', [OrderController::class, 'updateStatus'])->name('api.orders.update-status');
        Route::patch('/{id}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('api.orders.update-payment-status');
    });

Route::prefix('payment-methods')->group(function () {
    Route::get('/', [PaymentMethodController::class, 'index'])->name('api.payment-methods.index');
});
