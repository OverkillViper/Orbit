<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BuddyRequest;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;

class BuddyController extends Controller
{
    public function sendBuddyRequest(User $user) {
        $user_id = $user->id;

        BuddyRequest::create([
            'sender_id' => Auth::user()->id,
            'recipient_id' => $user_id,
        ]);

        Notification::create([
            'sender_id'    => Auth::user()->id, 
            'recipient_id' => $user_id,
            'title'        => 'New buddy request',
            'content'      => Auth::user()->name . ' has sent you a buddy request',
            'type'         => 'buddy_request_sent',
            'href'         => 'profile.buddies.requests',
        ]);

        return redirect()->back();
    }

    public function cancelBuddyRequest(User $user) {
        $buddy_request = BuddyRequest::where('recipient_id', '=', $user->id)->first();
        $buddy_request->delete();

        return redirect()->back();
    }

    public function declineBuddyRequest(BuddyRequest $buddyRequest) {
        $buddyRequest->delete();

        return redirect()->back();
    }

    public function acceptBuddyRequest(BuddyRequest $buddyRequest) {
        $buddyRequest->update([
            'accepted' => true,
            'accepted_on' => Carbon::now(),
        ]);

        Notification::create([
            'sender_id'    => Auth::user()->id, 
            'recipient_id' => $buddyRequest->sender->id,
            'title'        => 'New buddy',
            'content'      => Auth::user()->name . ' has accepted your buddy request',
            'type'         => 'buddy_request_accepted',
            'href'         => 'profile.buddies',
        ]);

        return redirect()->back();
    }
}
