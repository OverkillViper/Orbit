<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\BuddyRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Like;

class FeedController extends Controller
{
    public function index() {

        $buddy_requests = Auth::check() ? BuddyRequest::where('recipient_id', '=', Auth::user()->id)->where('accepted', false)->with('sender')->take(3)->get()->map(function ($request) {
            $createdAt = Carbon::parse($request->created_at);
            $now = Carbon::now();

            $secondsDifference = $createdAt->diffInSeconds($now);

            if ($secondsDifference < 60) {
                $request->time_difference = intval($secondsDifference) . ' seconds ago';
            } else {
                $minutesDifference = $createdAt->diffInMinutes($now);
                if ($minutesDifference < 60) {
                    $request->time_difference = intval($minutesDifference) . ' minutes ago';
                } else {
                    $hoursDifference = $createdAt->diffInHours($now);
                    if ($hoursDifference < 24) {
                        $request->time_difference = intval($hoursDifference) . ' hours ago';
                    } else {
                        $daysDifference = $createdAt->diffInDays($now);
                        $request->time_difference = intval($daysDifference) . ' days ago';
                    }
                }
            }

            return $request;
        }) : null;

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

        $posts = Post::with(['author', 'galleries'])
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
            'posts'          => $posts,
            'buddy_requests' => $buddy_requests,
            'buddies'        => $buddies,
        ];

        return Inertia::render('Feed/Index', $context);
    }

    public function storePost(Request $request) {
        $newPost = Post::create([
            'author_id'  => Auth::id(),
            'content'    => $request->content,
            'visibility' => $request->visibility,
            'group_id'   => $request->group_id,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images/posts', 'public');

                // Create a new Gallery entry
                $newPost->galleries()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('profile.posts');
    }

    public function toggleLikePost(Post $post) {

        $user_id = Auth::id();

        $existingLike = Like::where('likeable_id', $post->id)
            ->where('likeable_type', Post::class)
            ->where('user_id', $user_id)
            ->first();

        if($existingLike) {
            $existingLike->delete();
        } else {
            $post->likes()->create([
                'user_id' => $user_id,
            ]);
        }

        return redirect()->back();
    }
}
