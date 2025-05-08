<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\OrderItemController;

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    Route::middleware('user')->prefix('user')->group(function () {
        Route::get('/profile', [UserController::class, 'profile']);
    });
    
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/users', [AdminController::class, 'users']);
    });

    Route::middleware('user')->prefix('review')->group(function () {
        Route::get('/profile', [UserController::class, 'profile']);
    });
});

// review
Route::prefix('review')->group(function () {
    Route::get('/', [ReviewController::class, 'index']);
    Route::post('/create', [ReviewController::class, 'create'])->middleware('auth:sanctum')->middleware('user');
});

// category
Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/create', [CategoryController::class, 'create'])->middleware('auth:sanctum')->middleware('admin');
    Route::put('/update/{category}', [CategoryController::class, 'update'])->middleware('auth:sanctum')->middleware('admin');
    Route::delete('/delete/{category}', [CategoryController::class, 'destroy'])->middleware('auth:sanctum')->middleware('admin');
});

// menu
Route::prefix('menu')->group(function () {
    Route::get('/', [MenuController::class, 'index']);
    Route::get('/findByCategory/{category}', [MenuController::class, 'findByCategory']);
    Route::post('/create', [MenuController::class, 'create'])->middleware('auth:sanctum')->middleware('admin');
    Route::put('/update/{menu}', [MenuController::class, 'update'])->middleware('auth:sanctum')->middleware('admin');
    Route::put('/delete/{menu}', [MenuController::class, 'destroy'])->middleware('auth:sanctum')->middleware('admin');
});

// order
Route::prefix('order')->group(function () {
    Route::get('/', [OrderController::class, 'index']);

    Route::middleware('auth:sanctum')->middleware('user')->group(function () {
        Route::post('/create', [OrderController::class, 'create']);
        Route::put('/update/{order}', [OrderController::class, 'update']);
        Route::delete('/delete/{order}', [OrderController::class, 'destroy']);
    });
});

// order item
Route::prefix('order-item')->group(function () {
    Route::get('/', [OrderItemController::class, 'index']);

    Route::middleware('auth:sanctum')->middleware('user')->group(function () {
        Route::get('/findByOrder/{order}', [OrderItemController::class, 'findByOrder']);
        Route::post('/create', [OrderItemController::class, 'create']);
        Route::put('/update/{orderItem}', [OrderItemController::class, 'update']);
        Route::delete('/delete/{orderItem}', [OrderItemController::class, 'destroy']);
    });
});