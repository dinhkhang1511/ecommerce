<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

class NotificationController extends Controller
{
    public function markAllAsRead()
    {
        $headers = ['access_token' => Cookie::get('access_token')];
        $response = HttpService()->postDataWithBody('notifications/mark-all',[],$headers);

        // auth()->user()->unreadNotifications->markAsRead();
        if($response->status == 401)
            return error('logout');

        return success('dashboard');
    }
}
