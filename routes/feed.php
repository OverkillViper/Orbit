<?php

use App\Http\Controllers\FeedController;

Route::middleware('auth')->group(function () {
    Route::get('/feed', [FeedController::class, 'index'])->name('feed');
});