<?php

use App\Http\Controllers\FeedController;
use App\Http\Controllers\GroupController;

Route::middleware('auth')->group(function () {
    Route::get('/home',                                [FeedController::class, 'index'])->name('dashboard');

    // Post
    Route::post('create-post',                         [FeedController::class, 'storePost'])->name('post.store');
    Route::get('/post/{post}/details',                 [FeedController::class, 'postDetails'])->name('post.details');
    Route::get('/post/{post}/details/images/{image?}', [FeedController::class, 'postImageDetails'])->name('post.details.images');
    Route::put('/post/{post}/update',                  [FeedController::class, 'updatePost'])->name('post.update');
    Route::delete('/post/{post}/delete',               [FeedController::class, 'deletePost'])->name('post.delete');
    Route::delete('/post/images/{gallery}/remove',     [FeedController::class, 'removePostImage'])->name('post.image.remove');


    // Likes
    Route::post('like-post/{post}',                    [FeedController::class, 'toggleLikePost'])->name('posts.likes.toggle');
    Route::post('like-comment/{comment}',              [FeedController::class, 'toggleLikeComment'])->name('comments.likes.toggle');

    // Comments
    Route::post('/post/{post}/create-comment',         [FeedController::class, 'postComment'])->name('comment.store');
    Route::post('/post/comment/{comment}/remove',      [FeedController::class, 'deleteComment'])->name('comment.delete');

    // Groups
    Route::get('/groups',                              [GroupController::class, 'groups'])->name('groups');
});