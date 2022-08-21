<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
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
            if(! is_null($token) && !request()->routeIs('logout'))
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

    public function register()
    {
        return view('auth.register');
    }

    public function registered(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'password-confirm' =>[ 'required_with:password','same:password','min:6']]
        );

        $response = HttpService()->postDataWithBody('register', $data, []);
        if(($response->status ?? 200 ) == 402)
            return back()->with('error','Something went wrong');

        return success('login');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        Cookie::queue(Cookie::forget('access_token'));
        return success('login');
    }
}
