<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationUser extends Model
{
    use HasFactory;

    protected $fillable = ['conversation_id', 'user_id'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Get the user participating in the conversation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
