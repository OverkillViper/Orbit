<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['is_group', 'name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_users')
                    ->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getOtherParticipant($authUserId)
    {
        return $this->users()
                    ->where('user_id', '!=', $authUserId)
                    ->first();
    }
}
