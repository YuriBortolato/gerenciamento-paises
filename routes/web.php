<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post(
    '/login',
    [AuthController::class, 'webLogin']
)->name('login.submit');

Route::middleware('jwt.cookie')->group(function () {
    Route::get(
        '/countries',
        [CountryController::class, 'page']
    )->name('countries.index');

    Route::post(
        '/countries/import',
        [CountryController::class, 'importWeb']
    )->name('countries.import');

    Route::view(
        '/countries/create',
        'country-form'
    )->name('countries.create');

    Route::post(
        '/countries',
        [CountryController::class, 'storeWeb']
    )->name('countries.store');

    Route::get(
        '/countries/{id}/edit',
        [CountryController::class, 'editWeb']
    )->name('countries.edit');

    Route::get(
    '/countries/{id}',
    [CountryController::class, 'showWeb']
    )->name('countries.show');

    Route::put(
        '/countries/{id}',
        [CountryController::class, 'updateWeb']
    )->name('countries.update');

    Route::delete(
        '/countries/{id}',
        [CountryController::class, 'destroyWeb']
    )->name('countries.destroy');

    Route::post(
        '/logout',
        [AuthController::class, 'webLogout']
    )->name('logout');
});