<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class BuddyRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'recipient_id',
        'accepted',
        'accepted_on',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function buddy()
    {
        $authUserId = Auth::id();
        // Check if authenticated user is sender, return recipient, else return sender
        $otherUser = $this->sender_id === $authUserId ? $this->recipient : $this->sender;

        if ($otherUser) {
            $otherUser->is_active = $otherUser->isLoggedIn();
        }

        return $otherUser;
    }
}
