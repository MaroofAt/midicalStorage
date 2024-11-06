<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LangMiddleware;
use App\Http\Middleware\APIPassMiddleware;
use App\Http\Middleware\JWTPassMiddleware;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\TokenMiddleware;

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
});

