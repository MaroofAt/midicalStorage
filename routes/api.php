<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\LangMiddleware;
use App\Http\Middleware\JWTPassMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::middleware(JWTPassMiddleware::class , LangMiddleware::class)->group(function(){
    Route::middleware('auth:api' , 'api')->prefix('auth')->group(function(){
        Route::post('/register' , [AuthController::class, 'register'])->withoutMiddleware('auth:api');
        Route::post('/login' , [AuthController::class, 'login'])->withoutMiddleware('auth:api');
        Route::post('/logout' , [AuthController::class, 'logout']);
        Route::post('/me' , [AuthController::class, 'me']);
    });
});

