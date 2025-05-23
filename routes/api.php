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
use App\Http\Controllers\Api\PartyController;
use App\Http\Controllers\API\StripePaymentsController;
use App\Http\Controllers\API\EmailController;
use App\Http\Controllers\Api\OrderNoteController;
use App\Http\Controllers\API\ResetPasswordController;
use App\Http\Controllers\API\VerificationController;
use App\Http\Controllers\Api\VnpayController;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

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
            Route::post('/update/{category}', [CategoryController::class, 'update']);
            Route::delete('/delete/{category}', [CategoryController::class, 'destroy']);
        });
    });
});

// menu
Route::prefix('menu')->group(function () {
    Route::get('/', [MenuController::class, 'index']);
    Route::get('/findByCategory/{category}', [MenuController::class, 'findByCategory']);
    Route::get('/find/{id}', [MenuController::class, 'findById']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('admin')->group(function () {
            Route::post('/create', [MenuController::class, 'create']);
            Route::post('/update/{menu}', [MenuController::class, 'update']);
            Route::delete('/delete/{menu}', [MenuController::class, 'destroy']);
        });
    });
});

// order
Route::prefix('order')->group(function () {
    Route::get('/confirmPayment/{orderId}/{userId}', [OrderController::class, 'confirmPayment']);
    
    Route::middleware('auth:sanctum')->group(function () {

        Route::middleware('user')->group(function () {
            Route::post('/create', [OrderController::class, 'create']);
            Route::get('/getByOrderId/{orderId}', [OrderController::class, 'getByOrderId']);
            Route::get('/findByUser', [OrderController::class, 'indexByUser']);
            Route::get('/cancelByUser/{orderId}', [OrderController::class, 'cancelOrder']);
            Route::get('/markAsCompleted/{orderId}', [OrderController::class, 'markAsCompleted']);
            Route::get('/confirmOrder/{orderId}', [OrderController::class, 'confirmOrder']);
            Route::post('/updatePrice/{orderId}', [OrderController::class, 'updatePrice']);
            Route::delete('/delete/{order}', [OrderController::class, 'destroy']);
        });

        Route::middleware('admin')->group(function () {
            Route::get('/', [OrderController::class, 'index']);
            Route::get('/statusConfirmed/{orderId}', [OrderController::class, 'statusConfirmed']);
            Route::get('/statusCompleted/{orderId}', [OrderController::class, 'statusCompleted']);
            Route::get('/rejectOrder/{orderId}', [OrderController::class, 'rejectOrder']);
        });
    });
});

// order item
Route::prefix('order-item')->group(function () {
    Route::get('/', [OrderItemController::class, 'index']);
    Route::get('/findByOrder/{order}', [OrderItemController::class, 'findByOrder']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('user')->group(function () {
            Route::post('/create', [OrderItemController::class, 'create']);
            Route::post('/update/{orderItem}', [OrderItemController::class, 'update']);
            Route::get('/delete/{orderItem}', [OrderItemController::class, 'destroy']);
        });
    });
});

// Stripe payment routes
// Route::prefix('payment')->group(function () {
//     Route::middleware('auth:sanctum')->group(function () {
//         Route::middleware('user')->group(function () {
//             Route::get('/', [StripePaymentsController::class, 'index']);
//             Route::post('/create', [StripePaymentsController::class, 'payment']);
//             Route::get('/complete', [StripePaymentsController::class, 'complete']);
//         });
//     });
// });

// vnpay
Route::prefix('payment')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('user')->group(function () {
            Route::post('/create', [VnpayController::class, 'createPayment'])->name('payment.create');
        });
    });
    Route::get('/return', [VnPayController::class, 'vnpayReturn'])->name('vnpay.return');
});


// Party
Route::prefix('party')->group(function () {

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [PartyController::class, 'index']);
        Route::get('/{partyId}', [PartyController::class, 'getPartyByPartyId']);

        Route::middleware('admin')->group(function () {
            Route::post('/create', [PartyController::class, 'create']);
            Route::post('/updateByPartyId/{id}', [PartyController::class, 'updateByPartyId']);
            Route::get('/delete/{id}', [PartyController::class, 'destroy']);
        });
    });
});

// Email
Route::prefix('email')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::middleware('user')->group(function () {
            Route::post('/send', [EmailController::class, 'send']);
        });
    });
});
Route::get('/send-email', function () {
    $name = "Funny Coder";
    // The email sending is done using the to method on the Mail facade
    Mail::to('testreceiver@gmail.com')->send(new SendMail($name));
});

// reset password
Route::post('/forgot-password', [ResetPasswordController::class, 'sendMail']);
Route::get('/form-reset-password', [ResetPasswordController::class, 'showResetForm']);
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');


// order notes
Route::prefix('order-note')->group(function () {
    Route::get('/', [OrderNoteController::class, 'index']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/{orderNote}', [OrderNoteController::class, 'getByOrderNoteId']);
        Route::middleware('user')->group(function () {
        });
        Route::middleware('admin')->group(function () {
            Route::post('/create', [OrderNoteController::class, 'store']);
            Route::post('/update/{orderNote}', [OrderNoteController::class, 'updateByOrderNoteId']);
            Route::get('/delete/{orderNote}', [OrderNoteController::class, 'destroyByOrderNoteId']);
        });
    });
});
