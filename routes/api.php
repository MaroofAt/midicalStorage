<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LangMiddleware;
use App\Http\Middleware\TokenMiddleware;
use App\Http\Middleware\APIPassMiddleware;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminAuthController;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Middleware\AdminTokenMiddleware;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\MedicineController;
use App\Http\Middleware\LangMiddleware;
use App\Http\Middleware\TokenMiddleware;
use Illuminate\Support\Facades\Route;



// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware(APIPassMiddleware::class, LangMiddleware::class)->group(function () {

    Route::middleware('api')->prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);

        Route::middleware(TokenMiddleware::class)->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/me', [AuthController::class, 'me']);
            Route::post('/refresh', [AuthController::class, 'refresh']);
        });
    });


    Route::prefix('auth/admin')->group(function () {
        Route::post('/register',  [AdminAuthController::class, 'register']);
        Route::post('/login', [AdminAuthController::class, 'login']);

        Route::middleware(AdminTokenMiddleware::class . ':api_admin')->group(function () {
            Route::post('/logout', [AdminAuthController::class, 'logout']);
            Route::post('/me', [AdminAuthController::class, 'me']);
            Route::post('/refresh', [AdminAuthController::class, 'refresh']);

        });
    });



    Route::prefix('category')->group(function () {
        Route::post('/show', [CategoryController::class, 'show']);
        Route::post('/store', [CategoryController::class, 'store']);
        Route::post('/update', [CategoryController::class, 'update']);
        Route::post('/destroy', [CategoryController::class, 'destroy']);
        Route::post('/get_one', [CategoryController::class, 'get_one']);
    });


    Route::prefix('medicine')->group(function () {
        Route::post('/show', [MedicineController::class, 'show']);
        Route::post('/store', [MedicineController::class, 'store']);
        Route::post('/update', [MedicineController::class, 'update']);
        Route::post('/destroy', [MedicineController::class, 'destroy']);
        Route::post('/show_one_medicine', [MedicineController::class, 'show_one_medicine']);
        Route::post('/show_by_category', [MedicineController::class, 'show_by_category']);
    });


    Route::prefix('company')->group(function () {
        Route::post('/show', [CompanyController::class, 'show']);
        Route::post('/store', [CompanyController::class, 'store']);
        Route::post('/update', [CompanyController::class, 'update']);
        Route::post('/destroy', [CompanyController::class, 'destroy']);
        Route::post('/get_one', [CompanyController::class, 'get_one']);
    });



    Route::prefix('user')->group(function () {
        Route::post('/show', [UserController::class, 'show']);
        Route::post('/show_one', [UserController::class, 'show_one']);
        Route::post('/update', [UserController::class, 'update']);
    });


    Route::prefix('order')->group(function () {
        Route::post('/show', [OrderController::class, 'show']);
        Route::post('/store_one', [OrderController::class, 'store_one']);
        Route::post('/store_full_order', [OrderController::class, 'store_full_order']);
        Route::post('/update_status_paid', [OrderController::class, 'update_status_paid']);
        Route::post('/destroy', [OrderController::class, 'destroy']);

    });
});
