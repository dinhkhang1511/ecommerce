<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $guarded = [];

    public function attributes()
    {
        return $this->hasMany('App\Models\ProductAttribute');
    }
}
