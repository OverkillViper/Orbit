<?php

use App\Http\Controllers\MyProfileController;

Route::middleware('auth')->prefix('profile')->group(function () {
    // Posts
    Route::get('/posts',            [MyProfileController::class, 'posts'])->name('profile.posts');

    // Avatar
    Route::post('/update-avatar',   [MyProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::post('/remove-avatar',   [MyProfileController::class, 'removeAvatar'])->name('profile.avatar.remove');

    // Cover Photo
    Route::post('/update-cover-photo',   [MyProfileController::class, 'updateCoverPhoto'])->name('profile.coverphoto.update');
    Route::post('/remove-cover-photo',   [MyProfileController::class, 'removeCoverPhoto'])->name('profile.coverphoto.remove');

    // Buddies
    Route::get('/buddies',                 [MyProfileController::class, 'buddies'])->name('profile.buddies');
    Route::get('/buddy-requests',          [MyProfileController::class, 'buddyRequests'])->name('profile.buddies.requests');
    Route::get('/sent-buddy-requests',     [MyProfileController::class, 'sentBuddyRequests'])->name('profile.buddies.requests.sent');
});