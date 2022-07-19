<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function getAssignedUsersAttribute()
    {
        return $this->users()->get()->pluck('pivot.user_id');
    }
}
