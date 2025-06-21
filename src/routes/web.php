<?php

use App\Http\Controllers\CheckController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CheckController::class, 'home']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');




require __DIR__.'/auth.php';
