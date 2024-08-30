<?php

use App\Http\Controllers\BuddyController;

Route::middleware('auth')->prefix('buddies')->group(function () {
    Route::post('/{user}/request', [BuddyController::class, 'sendBuddyRequest'])->name('buddies.request');
    Route::post('/request/{user}/cancel', [BuddyController::class, 'cancelBuddyRequest'])->name('buddies.request.cancel');
    Route::post('/request/{buddyRequest}/decline', [BuddyController::class, 'declineBuddyRequest'])->name('buddies.request.decline');
    Route::post('/request/{buddyRequest}/accept',  [BuddyController::class, 'acceptBuddyRequest'])->name('buddies.request.accept');
});