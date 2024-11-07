<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LangMiddleware;
use App\Http\Middleware\APIPassMiddleware;
use App\Http\Middleware\JWTPassMiddleware;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MedicineController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::middleware(APIPassMiddleware::class, LangMiddleware::class)->group(function () {
    Route::middleware('auth:api', 'api')->prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->withoutMiddleware('auth:api');
        Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware('auth:api');
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/me', [AuthController::class, 'me']);
    });

    Route::prefix('medicine')->group(function () {
        Route::post('/show', [MedicineController::class, 'show']);
        Route::post('/store', [MedicineController::class, 'store']);
        Route::post('/update', [MedicineController::class, 'update']);
        Route::post('/destroy', [MedicineController::class, 'destroy']);
        Route::post('/show_one_medicine', [MedicineController::class, 'show_one_medicine']);
        Route::post('/show_by_category', [MedicineController::class, 'show_by_category']);
    });
});
