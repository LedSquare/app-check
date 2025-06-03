<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Profile\ProfileUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/**
 * Laravel ui routes
 */
Auth::routes();

Route::controller(HomeController::class)->name('home')->group(function () {
    Route::get('/', 'index');
});

Route::controller(ProfileUserController::class)
    ->name('profile')
    ->prefix('profile')
    ->middleware('auth')
    ->group(function () {
        Route::get('', 'index')->name('.user');
        Route::post('', 'update')->name('.update');
    });
