<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Role;
use App\Mail\SendEmail;
use App\Models\RoleUser;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function create()
    {
        $roles = Role::all();
        $customers = User::customer()->get();
        return view('backend.sendEmail.create', compact('roles', 'customers'));
    }

    public function store()
    {
        $paths = [];
        foreach (request('file_upload', []) as $value) {
            $paths[] = store_file($value, 'emails');
        }

        $customer_emails = [];
        if (request()->exists('customer_role')) {
            $customer_emails = User::customer()->pluck('email');
        }
        
        $role_emails = RoleUser::with('user')->whereIn('id', request('roles', []))->get()->pluck('user.email');
        $individual_emails = Arr::where(request('individual_emails', []), function ($value, $key) {
            return $value != null;
        });
        $emails = array_unique(Arr::collapse([$role_emails, $individual_emails, $customer_emails]));
        
        if (count($emails) == 0) {
            return error('send-email.create', 'Please choose email');
        }
        Mail::to('thanhphu2410@gmail.com')
            ->bcc($emails)
            ->queue(new SendEmail(request('body'), $paths));
        return back();
    }
}
