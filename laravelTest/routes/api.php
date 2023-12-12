<?php

use App\Http\Controllers\APIs\LoginController;
use App\Http\Controllers\APIs\ProductController;
use App\Http\Controllers\APIs\OrderController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('signup', [LoginController::class, 'signup']);
Route::post('signin', [LoginController::class, 'signin']);

// Product endpoints
Route::prefix('products')->middleware(['auth:sanctum', 'check.role:seller'])->group(function () {
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}/edit', [ProductController::class, 'show']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}/delete', [ProductController::class, 'destroy']);
    Route::get('/orders', [OrderController::class, 'index']);
});

// Order endpoints
Route::prefix('orders')->middleware(['auth:sanctum', 'check.role:buyer'])->group(function () {
    Route::post('/', [OrderController::class, 'store']);
    Route::get('/{id}/show', [OrderController::class, 'show']);
});
