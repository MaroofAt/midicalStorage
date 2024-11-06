<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\APIPassMiddleware;
use App\Http\Middleware\JWTPassMiddleware;
use App\Http\Middleware\LangMiddleware;
use App\Http\Middleware\TokenMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::middleware(APIPassMiddleware::class , LangMiddleware::class)->group(function(){

    Route::middleware('api')->prefix('auth')->group(function(){
        Route::post('/register' , [AuthController::class, 'register']);
        Route::post('/login' , [AuthController::class, 'login']);

        Route::middleware(TokenMiddleware::class , 'auth:api')->group(function(){
            Route::post('/logout' , [AuthController::class, 'logout']);
            Route::post('/me' , [AuthController::class, 'me']);
            Route::post('/refresh' , [AuthController::class, 'refresh']);
        });

    });


    Route::prefix('category')->group(function(){
        Route::post('/show' , [CategoryController::class , 'show']);
        Route::post('/store' , [CategoryController::class , 'store']);
        Route::post('/update' , [CategoryController::class , 'update']);
        Route::post('/destroy' , [CategoryController::class , 'destroy']);
        Route::post('/get_one' , [CategoryController::class , 'get_one']);
    });

    Route::prefix('order')->group(function(){
        Route::post('/show' , [OrderController::class , 'show']);
        Route::post('/store_one' , [OrderController::class , 'store_one']);
        Route::post('/update_status_paid' , [OrderController::class , 'update_status_paid']);
        Route::post('/destroy' , [OrderController::class , 'destroy']);
    });

});

