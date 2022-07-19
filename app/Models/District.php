<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public function wards()
    {
        return $this->hasMany('App\Models\Ward');
    }
}
