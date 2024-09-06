<?php

namespace App\Helpers;

use App\Models\BuddyRequest;
use Illuminate\Support\Facades\Auth;

class BuddyHelper {
    public static function getBuddiesCount() {
        $buddies_count = BuddyRequest::where('accepted', true)
                                     ->where(function ($query) {
                                         $query->where('sender_id', Auth::id())
                                             ->orWhere('recipient_id', Auth::id());
                                     })
                                     ->count();
    
        return $buddies_count;
    }
}