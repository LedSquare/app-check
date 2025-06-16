<?php

use App\Http\Controllers\TimeReportController;
use App\Http\Controllers\TimeTrackController;
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



Route::get('/time-parse', [TimeTrackController::class, 'showForm'])->name('time.parse.form');
Route::post('/time-parse', [TimeTrackController::class, 'parseTime'])->name('time.parse');
