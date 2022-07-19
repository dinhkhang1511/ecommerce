<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function findNotification($id)
    {
        return auth()->user()->notifications()->where('id', $id)->first();
    }
}
