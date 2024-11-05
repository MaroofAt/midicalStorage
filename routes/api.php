<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LangMiddleware;
use App\Http\Middleware\APIPassMiddleware;
use App\Http\Middleware\JWTPassMiddleware;
use App\Http\Controllers\Api\AuthController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::middleware(APIPassMiddleware::class , LangMiddleware::class)->group(function(){
    Route::middleware('auth:api' , 'api')->prefix('auth')->group(function(){
        Route::post('/register' , [AuthController::class, 'register'])->withoutMiddleware('auth:api');
        Route::post('/login' , [AuthController::class, 'login'])->withoutMiddleware('auth:api');
        Route::post('/logout' , [AuthController::class, 'logout']);
        Route::post('/me' , [AuthController::class, 'me']);
    });
});

