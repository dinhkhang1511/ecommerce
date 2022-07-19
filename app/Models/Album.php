<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = ['title', 'description', 'display'];

    public function images()
    {
        return $this->hasMany('App\Models\AlbumImage', 'album_id', 'id');
    }

    public function scopeDisplay($query)
    {
        return $query->where('display', 1);
    }
}
