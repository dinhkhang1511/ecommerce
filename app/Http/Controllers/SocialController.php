<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    
    public function callback($provider)
    {
        try {
            $getInfo = Socialite::driver($provider)->user();
            if ($getInfo->email == null) {
                return error();
            }
            $user = $this->createUser($getInfo);
            auth()->login($user);
            return redirect()->to('/');
        } catch (\Exception $th) {
            return error('home', 'Login failed');
        }
    }
    
    public function createUser($getInfo)
    {
        try {
            $user = User::where('email', $getInfo->email)->first();
            if (!$user) {
                $user = User::create([
                    'name'     => $getInfo->name,
                    'email'    => $getInfo->email,
                    'avatar'   => $getInfo->avatar,
                    'password' => Hash::make('123456'),
                ]);
            }
            return $user;
        } catch (\Exception $th) {
            return error('home', 'Login failed');
        }
    }
}
