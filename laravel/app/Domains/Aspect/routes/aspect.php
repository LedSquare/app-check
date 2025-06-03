<?php

use Aspect\Http\Controllers\AspectController;
use Aspect\Http\Controllers\AspectIsActiveController;
use Illuminate\Support\Facades\Route;


Route::controller(AspectController::class)
    ->name('aspect')
    ->middleware('auth')
    ->group(function () {
        Route::get('start', 'start')->name('.start');
        Route::post('next-step/{aspect}', 'next')->name('.store');
        Route::get('current/{aspect}', 'current')->name('.current');
        Route::get('aspects', 'list')->name('.list');
        Route::get('report/{aspect}', 'report')->name('.report');
    });

Route::get('is-active', AspectIsActiveController::class)
    ->middleware('auth')
    ->name('aspect.is-active');
