<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
use App\Models\User;

class MessageController extends Controller
{

    public function getConversations() {
        $conversations = Conversation::whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
        })->with(['users', 'messages'])->get()->map(function ($conversation) {
            $conversation->other_user = $conversation->getOtherParticipant(Auth::id());

            return $conversation;
        });

        return $conversations;
    }

    public function conversations() {
        
        $context = [
            'conversations' => $this->getConversations(),
        ];

        return Inertia::render('Messages/ConversationIndex', $context);
    }

    public function startConversation(User $user) {

        $authUserId = Auth::id();
        $userId = $user->id;

        $conversation = Conversation::where('is_group', false)
        ->whereHas('users', function ($query) use ($authUserId) {
            $query->where('user_id', $authUserId);
        })
        ->whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->first();

        if($conversation) {
            return redirect()->route('messages.conversation', $conversation->id);
        } else {
            $conversation = Conversation::create([
                'is_group' => false,
            ]);
    
            // Attach both users to the conversation
            $conversation->users()->attach([$authUserId, $userId]);

            return redirect()->route('messages.conversation', $conversation->id);
        }
    }

    public function conversation(Conversation $conversation) {
        $context = [
            'conversation' => $conversation,
            'conversations' => $this->getConversations(),
        ];

        return Inertia::render('Messages/Conversation', $context);
    }
}
