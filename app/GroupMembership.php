<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMembership extends Model
{
    protected $appends = ['joined_when'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function getJoinedWhenAttribute()
    {
        return $this->created_at->diffForHumans();;

    }
}
