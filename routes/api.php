<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:api')->group(function () {
    Route::post(
        '/countries/import',
        [CountryController::class, 'import']
    );

    Route::get(
        '/countries',
        [CountryController::class, 'index']
    );

    Route::get(
        '/countries/{id}',
        [CountryController::class, 'show']
    );

    Route::post(
        '/countries',
        [CountryController::class, 'store']
    );

    Route::put(
        '/countries/{id}',
        [CountryController::class, 'update']
    );

    Route::delete(
        '/countries/{id}',
        [CountryController::class, 'destroy']
    );
});