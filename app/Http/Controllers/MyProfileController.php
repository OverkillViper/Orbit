<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\BuddyRequest;
use App\Models\Post;
use Carbon\Carbon;

class MyProfileController extends Controller
{

    public function updateAvatar(Request $request) {
        $data = $request->validate([
            'avatar' => 'required'
        ]);

        if ($request->hasFile('avatar')) {
            if (isset(Auth::user()->avatar)) {
                Storage::disk('public')->delete(Auth::user()->avatar);
            }
            $avatarPath = $request->file('avatar')->store('images/avatars', 'public');

            $data['avatar'] = $avatarPath;

            $updatedUser = Auth::user()->update($data);

            return redirect()->back();
        }
    }

    public function removeAvatar() {

        if (isset(Auth::user()->avatar)) {
            Storage::disk('public')->delete(Auth::user()->avatar);
        }

        $updatedUser = Auth::user()->update([
            'avatar' => null
        ]);

        return redirect()->back();
    }

    public function updateCoverPhoto(Request $request) {
        $data = $request->validate([
            'coverPhoto' => 'required'
        ]);

        if ($request->hasFile('coverPhoto')) {
            if (isset(Auth::user()->cover_photo)) {
                Storage::disk('public')->delete(Auth::user()->cover_photo);
            }
            $coverPhotoPath = $request->file('coverPhoto')->store('images/cover_photos', 'public');

            $data['cover_photo'] = $coverPhotoPath;

            $updatedUser = Auth::user()->update($data);

            return redirect()->back();
        }
    }

    public function removeCoverPhoto() {

        if (isset(Auth::user()->cover_photo)) {
            Storage::disk('public')->delete(Auth::user()->cover_photo);
        }

        $updatedUser = Auth::user()->update([
            'cover_photo' => null
        ]);

        return redirect()->back();
    }

    private function getBuddiesCount() {
        $buddies_count = BuddyRequest::where('accepted', true)
                                     ->where(function ($query) {
                                         $query->where('sender_id', Auth::id())
                                             ->orWhere('recipient_id', Auth::id());
                                     })
                                     ->count();

        return $buddies_count;
    }

    public function posts() {

        $posts = Post::where('author_id', '=', Auth::id())
                     ->with(['author', 'galleries'])
                     ->withCount('likes')
                     ->withCount(['likes as isLiked' => function ($query) {
                         $query->where('user_id', Auth::id());
                     }])
                     ->orderBy('created_at', 'desc')
                     ->get()
                     ->map(function ($post) {
                         // Calculate time difference
                         $createdAt = Carbon::parse($post->created_at);
                         $now = Carbon::now();
                 
                         $secondsDifference = $createdAt->diffInSeconds($now);
                 
                         if ($secondsDifference < 60) {
                             $post->time_difference = intval($secondsDifference) . ' seconds ago';
                         } else {
                             $minutesDifference = $createdAt->diffInMinutes($now);
                             if ($minutesDifference < 60) {
                                 $post->time_difference = intval($minutesDifference) . ' minutes ago';
                             } else {
                                 $hoursDifference = $createdAt->diffInHours($now);
                                 if ($hoursDifference < 24) {
                                     $post->time_difference = intval($hoursDifference) . ' hours ago';
                                 } else {
                                     $daysDifference = $createdAt->diffInDays($now);
                                     $post->time_difference = intval($daysDifference) . ' days ago';
                                 }
                             }
                         }
                 
                         // Convert the like count to a boolean
                         $post->isLiked = $post->isLiked > 0;
                 
                         return $post;
                     });


        $context = [
            'posts'         => $posts,
            'buddies_count' => $this->getBuddiesCount(),
        ];

        return Inertia::render('MyProfile/Posts', $context);
    }

    public function buddies() {
        $buddies = BuddyRequest::where('accepted', true)
                               ->where(function ($query) {
                                   $query->where('sender_id', Auth::id())
                                         ->orWhere('recipient_id', Auth::id());
                               })
                               ->get()
                               ->map(function ($buddyRequest) {
                                   // Use the buddy() method to get the other user
                                   $buddyRequest->buddy = $buddyRequest->buddy();
                                   return $buddyRequest;
                               });

        $buddy_requests = BuddyRequest::where('recipient_id', '=', Auth::id())
                                      ->where('accepted', false)->count();

        $context = [
            'buddies'        => $buddies,
            'buddies_count'  => $this->getBuddiesCount(),
            'buddy_requests' => $buddy_requests
        ];

        return Inertia::render('MyProfile/Buddies', $context);
    }

    public function buddyRequests() {
        $buddy_requests = BuddyRequest::where('recipient_id', '=', Auth::id())
                                      ->where('accepted', false)->with('sender')->get();

        $context = [
            'buddy_requests' => $buddy_requests,
            'buddies_count'  => $this->getBuddiesCount(),
        ];

        return Inertia::render('MyProfile/BuddyRequests', $context);
    }

    public function sentBuddyRequests() {
        $sent_buddy_requests = BuddyRequest::where('sender_id', '=', Auth::id())
                                      ->where('accepted', false)->with('recipient')->get();

        $context = [
            'sent_buddy_requests' => $sent_buddy_requests,
            'buddies_count'       => $this->getBuddiesCount(),
        ];

        return Inertia::render('MyProfile/SentBuddyRequests', $context);
    }
}
