<?php

namespace App\Rules;

use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class MatchOldPassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $token = Cookie::get('access_token');
        $headers = ['access_token' => $token];
        $api_url = config('app.api_url');

        $response = HttpService()->postDataWithBody('check-password',['password' => $value], $headers );
        $response = Http::withHeaders($headers)->post("$api_url/check-password",['password' => $value]);
        return $response->status() == 200;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute requires a match with an old password.';
    }
}
