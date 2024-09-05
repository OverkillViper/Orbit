<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\BuddyRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Like;
use App\Models\Gallery;
use App\Models\Comment;
use App\Helpers\TimeHelper;

class FeedController extends Controller
{

    private function getComments(Post $post) {
        $comments = Comment::where('post_id', $post->id)
        ->with(['replies' => function ($query) {
            $query->with(['author', 'gallery', 'likes']) // Load related data for replies
                ->withCount('likes')
                ->withCount(['likes as isLiked' => function ($query) {
                    $query->where('user_id', Auth::id());
                }]);
        }, 'author', 'gallery', 'likes', 'post'])
        ->withCount('likes')
        ->withCount(['likes as isLiked' => function ($query) {
            $query->where('user_id', Auth::id());
        }])
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($comment) {
            $comment = TimeHelper::addTimeDifference($comment);
            $comment->isLiked = $comment->isLiked > 0;

            $comment->replies = $comment->replies->map(function ($reply) {
                $reply = TimeHelper::addTimeDifference($reply);
                $reply->isLiked = $reply->isLiked > 0;
                return $reply;
            });

            return $comment;
        });

        return $comments;
    }

    public function index() {

        $buddy_requests = Auth::check() ?
            BuddyRequest::where('recipient_id', '=', Auth::user()->id)
                        ->where('accepted', false)
                        ->with('sender')
                        ->take(3)
                        ->get()
                        ->map(function ($request) {
                            $request = TimeHelper::addTimeDifference($request);
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

        $posts = Post::with(['author', 'galleries', 'group'])
                    ->withCount('likes')
                    ->withCount(['likes as isLiked' => function ($query) {
                        $query->where('user_id', Auth::id());
                    }])
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(function ($post) {
                        $post = TimeHelper::addTimeDifference($post);
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

    public function deletePost(Post $post) {

        $galleries = Gallery::where('imageable_type', Post::class)->where('imageable_id', $post->id)->get();

        foreach ($galleries as $gallery) {
            $gallery->delete();
        }

        $post->delete();

        return redirect()->back();
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

    public function removePostImage(Gallery $gallery) {
        $gallery->delete();

        return redirect()->back();
    }

    public function toggleLikeComment(Comment $comment) {

        $user_id = Auth::id();

        $existingLike = Like::where('likeable_id', $comment->id)
            ->where('likeable_type', Comment::class)
            ->where('user_id', $user_id)
            ->first();

        if($existingLike) {
            $existingLike->delete();
        } else {
            $comment->likes()->create([
                'user_id' => $user_id,
            ]);
        }

        return redirect()->back();
    }

    public function postDetails(Request $request, Post $post) {

        $post->load(['author', 'galleries', 'group'])
            ->loadCount('likes')
            ->loadCount(['likes as isLiked' => function ($query) {
                $query->where('user_id', Auth::id());
            }]);

        // Calculate time difference
        $post = TimeHelper::addTimeDifference($post);

        $comments = $this->getComments($post);

        // Convert the isLiked count to a boolean
        $post->isLiked = $post->isLiked > 0;

        $context = [
            'post'      => $post,
            'comments'  => $comments
        ];

        return Inertia::render('Posts/PostDetails', $context);
    }

    public function postImageDetails(Post $post, Gallery $image = null)
    {
        // Load post details with necessary relationships
        $post->load(['author', 'galleries', 'group'])
            ->loadCount('likes')
            ->loadCount(['likes as isLiked' => function ($query) {
                $query->where('user_id', Auth::id());
            }]);

        // Calculate time difference (same as above)
        $post = TimeHelper::addTimeDifference($post);

        $post->isLiked = $post->isLiked > 0;

        // Determine current image index for navigation
        $currentimageIndex = $image ? $post->galleries->search(fn($img) => $img->id === $image->id) : 0;
        $previousimage = $post->galleries[$currentimageIndex - 1] ?? null;
        $nextimage = $post->galleries[$currentimageIndex + 1] ?? null;

        $comments = $this->getComments($post);

        $context = [
            'post'          => $post,
            'currentimage'  => $image ?? $post->galleries()->first(),
            'previousimage' => $previousimage,
            'nextimage'     => $nextimage,
            'comments'      => $comments
        ];

        // Return post details with the specific image
        return Inertia::render('Posts/PostDetails', $context);
    }

    public function postComment(Request $request, Post $post) {

        $newComment = Comment::create([
            'parent_id' => $request->parent_id,
            'post_id'   => $post->id,
            'content'   => $request->content,
            'author_id' => Auth::id(),
        ]);

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $path = $image->store('images/comments', 'public');

                // Create a new Gallery entry
                $newComment->galleries()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->back();
    }

    public function updatePost(Request $request, Post $post) {
        $post->update([
            'content'    => $request->content,
            'visibility' => $request->visibility,
            'group_id'   => $request->group_id,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images/posts', 'public');

                // Create a new Gallery entry
                $post->galleries()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->back();
    }

    public function deleteComment(Comment $comment) {
        $comment->delete();

        return redirect()->back();
    }
}
