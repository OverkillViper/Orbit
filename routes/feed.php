<?php

use App\Http\Controllers\FeedController;

Route::middleware('auth')->group(function () {
    Route::get('/home',                                [FeedController::class, 'index'])->name('dashboard');

    // Post
    Route::post('create-post',                         [FeedController::class, 'storePost'])->name('post.store');
    Route::get('/post/{post}/details',                 [FeedController::class, 'postDetails'])->name('post.details');
    Route::get('/post/{post}/details/images/{image?}', [FeedController::class, 'postImageDetails'])->name('post.details.images');
    
    // Likes
    Route::post('like-post/{post}',                    [FeedController::class, 'toggleLikePost'])->name('posts.likes.toggle');
    Route::post('like-comment/{comment}',              [FeedController::class, 'toggleLikeComment'])->name('comments.likes.toggle');
    // Comments
    Route::post('/post/{post}/create-comment',         [FeedController::class, 'postComment'])->name('comment.store');
});