<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    //

    private $apiUrl;


    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $token = Cookie::get('access_token');
            if(! is_null($token))
                return redirect()->route('dashboard');
            else
            {
                $this->apiUrl = config('app.api_url');
                return $next($request);
            }
        });
    }


    public function login()
    {
        return view('auth.login');
    }

    public function checkLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $response = Http::post("$this->apiUrl/login",$request->all());
        if($response->successful())
        {
            $payload = $this->respondToData($response);
            $request->session()->put('user',$payload->data);
            return redirect()->route('home')->with('success','Operation success')
                             ->cookie('access_token',$payload->token);
        }
        return redirect()->back()->with('error','Your credentials did not match');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->forget('access_token');
        return redirect()->route('home')->with('success','Operation success');
    }
}
