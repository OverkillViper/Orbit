<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'parent_id',
        'content',
        'post_id',
    ];

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function gallery()
    {
        return $this->morphMany(Gallery::class, 'imageable');
    }

    public function isLiked()
    {
        // Check if the likes collection contains a like by the authenticated user
        return $this->likes()->where('user_id', Auth::id())->exists();
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
