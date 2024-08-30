<?php

use App\Http\Controllers\FrontendController;

Route::middleware('auth')->group(function () {
    Route::get('/search', [FrontendController::class, 'search'])->name('search');

    // Notification
    Route::get('/notification-visit/{notification}', [FrontendController::class, 'visitNotification'])->name('notification.visit');
    Route::post('notification/{notification}/delete', [FrontendController::class, 'deleteNotification'])->name('notification.delete');
});
