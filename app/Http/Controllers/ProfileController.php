<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProfileController extends Controller
{
    public function editProfile()
    {
        $user = session('user',[]);
        $provinces = getData()->getDataFromType('locations/provinces')->data;
        return view('frontend.profile.edit_profile', compact('user', 'provinces'));
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        if($user = session('user'))
        {
            if (request()->has('avatar')) {
                delete_file($user->avatar);
            }
            User::find($user->id)->update($request->validated());
            return success('edit-profile');
        }
        else return error();
    }

    public function editPassword()
    {
        $user = session('user',[]);
        return view('frontend.profile.edit_password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $user = session('user',[]);
        $headers = ['access_token' => Cookie::get('access_token')];
        $response = HttpService()->postDataWithBody('update-password',$request->all(),$headers);
        if(($response->status) == 402)
            return back()->with('errors', $response->errors);

        return success();
    }
}
