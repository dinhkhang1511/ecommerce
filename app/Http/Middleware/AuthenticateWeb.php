<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class AuthenticateWeb
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
        $user = session('user');
        $token = Cookie::get('access_token');
        $api_url = config('app.api_url');
        if(! is_null($token))
        {
            if($user)
                return $next($request);
            else
            {
                $response = Http::post("$api_url/authenticate",['access_token' => $token]);
                if($response->successful())
                {
                    $user = json_decode($response->getBody()->getContents());
                    $request->session()->put('user',$user);
                    return $next($request);
                }
                else
                    return error('login','Invalid User');
            }
        }
        return error('login','Invalid User');
    }
}
