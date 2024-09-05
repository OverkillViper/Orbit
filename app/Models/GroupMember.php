<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'group_id',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
