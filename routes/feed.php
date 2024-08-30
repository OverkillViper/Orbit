<?php

use App\Http\Controllers\FeedController;

Route::middleware('auth')->group(function () {
    Route::get('/home', [FeedController::class, 'index'])->name('dashboard');

    // Post
    Route::post('create-post', [FeedController::class, 'storePost'])->name('post.store');

    // Likes
    Route::post('like-post/{post}',   [FeedController::class, 'toggleLikePost'])->name('posts.likes.toggle');
});