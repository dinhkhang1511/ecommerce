<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
