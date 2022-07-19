<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['name', 'code'];

    public function attributes()
    {
        return $this->hasMany('App\Models\ProductAttribute');
    }
}
