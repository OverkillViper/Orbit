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
    Route::get('/post/{post}/likes',                   [FeedController::class, 'postLikes'])->name('post.likes');
    Route::get('/post/{post}/likes/images/{image?}',   [FeedController::class, 'postImageLikes'])->name('post.likes.images');

    // Likes
    Route::post('like-post/{post}',                    [FeedController::class, 'toggleLikePost'])->name('posts.likes.toggle');
    Route::post('like-comment/{comment}',              [FeedController::class, 'toggleLikeComment'])->name('comments.likes.toggle');

    // Comments
    Route::post('/post/{post}/create-comment',         [FeedController::class, 'postComment'])->name('comment.store');
    Route::post('/post/comment/{comment}/remove',      [FeedController::class, 'deleteComment'])->name('comment.delete');

    // Groups
    Route::get('/groups',                              [GroupController::class, 'groups'])->name('groups');
    Route::get('/groups/discover',                     [GroupController::class, 'discoverGroups'])->name('groups.discover');
    Route::post('/group/create',                       [GroupController::class, 'createGroup'])->name('group.create');
    Route::delete('/group/{group}/delete',             [GroupController::class, 'deleteGroup'])->name('group.delete');
    Route::get('/group/{group}/posts',                 [GroupController::class, 'groupPosts'])->name('group.posts');
    Route::get('/group/{group}/members',               [GroupController::class, 'groupMembers'])->name('group.members');
    Route::post('/group/{group}/join',                 [GroupController::class, 'joinGroup'])->name('group.join');
    Route::post('/group/{group}/leave',                [GroupController::class, 'leaveGroup'])->name('group.leave');
    Route::post('/group/{group}/cancel-request',       [GroupController::class, 'cancelJoinRequest'])->name('group.request.cancel');
    Route::get('/group/{group}/requests',              [GroupController::class, 'memberRequests'])->name('group.members.requests');
    Route::post('/group/request/{request}/accept',     [GroupController::class, 'acceptJoinRequest'])->name('group.members.request.accept');
    Route::post('/group/request/{request}/decline',    [GroupController::class, 'declineJoinRequest'])->name('group.members.request.decline');
    Route::get('/group/{group}/about',                 [GroupController::class, 'aboutGroup'])->name('group.about');
    Route::get('/group/joined',                        [GroupController::class, 'joinedGroups'])->name('groups.joined');
});