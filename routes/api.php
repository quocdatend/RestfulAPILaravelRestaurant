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
use App\Http\Controllers\API\StripePaymentsController;

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
});

// review
Route::prefix('review')->group(function () {
    Route::get('/', [ReviewController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('user')->group(function () {
            Route::post('/create', [ReviewController::class, 'create']);
        });
    });
});

// category
Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/slug/{slug}', [CategoryController::class, 'findBySlug']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('admin')->group(function () {
            Route::post('/create', [CategoryController::class, 'create']);
            Route::put('/update/{category}', [CategoryController::class, 'update']);
            Route::delete('/delete/{category}', [CategoryController::class, 'destroy']);
        });
    });
});

// menu
Route::prefix('menu')->group(function () {
    Route::get('/', [MenuController::class, 'index']);
    Route::get('/findByCategory/{category}', [MenuController::class, 'findByCategory']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('admin')->group(function () {
            Route::post('/create', [MenuController::class, 'create']);
            Route::put('/update/{menu}', [MenuController::class, 'update']);
            Route::delete('/delete/{menu}', [MenuController::class, 'destroy']);
        });
    });
});

// order
Route::prefix('order')->group(function () {
    Route::get('/', [OrderController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('user')->group(function () {
            Route::post('/create', [OrderController::class, 'create']);
            Route::put('/update/{order}', [OrderController::class, 'update']);
            Route::delete('/delete/{order}', [OrderController::class, 'destroy']);
        });
    });
});

// order item
Route::prefix('order-item')->group(function () {
    Route::get('/', [OrderItemController::class, 'index']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('user')->group(function () {
            Route::get('/findByOrder/{order}', [OrderItemController::class, 'findByOrder']);
            Route::post('/create', [OrderItemController::class, 'create']);
            Route::put('/update/{orderItem}', [OrderItemController::class, 'update']);
            Route::delete('/delete/{orderItem}', [OrderItemController::class, 'destroy']);
        });
    });
});

// Stripe payment routes
Route::prefix('payment')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('user')->group(function () {
            Route::get('/', [StripePaymentsController::class, 'index']);
            Route::post('/create', [StripePaymentsController::class, 'payment']);
            Route::get('/complete', [StripePaymentsController::class, 'complete']);
        });
    });
});
