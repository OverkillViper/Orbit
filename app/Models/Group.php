<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'visibility',
        'admin_id',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class,'group_id');
    }

    public function members()
    {
        return $this->hasMany(GroupMember::class, 'group_id')->where('status', 'approved');
    }
}
