<?php

use App\Http\Controllers\FeedController;

Route::middleware('auth')->group(function () {
    Route::get('/home', [FeedController::class, 'index'])->name('dashboard');
});