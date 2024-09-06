<?php
use App\Http\Controllers\MessageController;

Route::middleware('auth')->prefix('messages')->group(function () {
    Route::get('/conversations',                    [MessageController::class, 'conversations'])->name('messages.conversations');
    Route::get('/conversation/{conversation}',      [MessageController::class, 'conversation'])->name('messages.conversation');
    Route::get('/start-conversation/{user}',        [MessageController::class, 'startConversation'])->name('messages.conversation.start');
});