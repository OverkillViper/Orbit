<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\BuddyRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'cover_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getBuddyStatus($otherUserId = null) {
        if (is_null($otherUserId)) {
            return 'none';
        }

        $buddy = BuddyRequest::where(function ($query) use ($otherUserId) {
                                 $query->where('sender_id', $this->id)
                                     ->where('recipient_id', $otherUserId)
                                     ->where('accepted', true);
                             })
                             ->orWhere(function ($query) use ($otherUserId) {
                                 $query->where('sender_id', $otherUserId)
                                     ->where('recipient_id', $this->id)
                                     ->where('accepted', true);
                             })
                             ->first();

        if ($buddy) {
            return 'buddy';
        }

        // Check if the current user has sent a buddy request
        $buddyRequest = BuddyRequest::where('sender_id', $this->id)
                                    ->where('recipient_id', $otherUserId)
                                    ->where('accepted', false)
                                    ->first();

        if ($buddyRequest) {
            return 'request_sent';
        }

        // No relationship exists
        return 'none';
    }

    public function isLoggedIn()
    {

        $fiveMinutesAgo = Carbon::now()->subMinutes(5);

        return DB::table('sessions')
            ->where('user_id', $this->id)
            ->where('last_activity', '>=', $fiveMinutesAgo)
            ->exists();
    }
}
