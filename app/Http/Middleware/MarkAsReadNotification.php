<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Notification;

class MarkAsReadNotification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (request('notification')) {
            $notification = (new Notification())->findNotification(request('notification'));
            $notification->markAsRead();
            return redirect()->to(url()->current());
        }
        return $next($request);
    }
}
