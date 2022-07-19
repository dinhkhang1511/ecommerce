<?php

namespace App\Http\Middleware;

use Closure;

class CheckStaff
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
        if(session()->has('user'))
        {
            $user = session('user');
            if ($user && in_array('Admin',$user->roles))
                return $next($request);
        }
        return redirect('/')->with('error','Operation Fail');
    }
}
