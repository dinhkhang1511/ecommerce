<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\User;

class ProfileController extends Controller
{
    public function editProfile()
    {
        $user = auth()->user();
        $provinces = Province::all();
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
        $user = auth()->user();
        return view('frontend.profile.edit_password', compact('user'));
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        $password = Hash::make($request->new_password);
        auth()->user()->update(['password' => $password]);
        return success();
    }
}
