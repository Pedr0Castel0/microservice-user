<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
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


