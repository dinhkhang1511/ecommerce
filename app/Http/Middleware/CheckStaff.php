<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;

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
        $api_url = config('app.api_url');
        if(session()->has('user'))
        {
            $user = session('user');
            if ($user && strcmp('Admin',$user->roles) == 0)
                return $next($request);
        }
        elseif($token = $request->cookie('access_token'))
        {
            $response = Http::post("$api_url/authenticate",['access_token' => $token]);
                if($response->successful())
                {
                    $user = json_decode($response->getBody()->getContents());
                    $request->session()->put('user',$user);
                    if ($user && strcmp('Admin',$user->roles) == 0)
                        return $next($request);
                }
                else
                    return error('login','Invalid User');
        }
        return redirect('/')->with('error','Operation Fail');
    }
}
