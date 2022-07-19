<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            'gender' => ['nullable', 'string'],
            'date_of_birth' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'province_id' => ['nullable', 'numeric'],
            'district_id' => ['nullable', 'numeric'],
            'ward_id' => ['nullable', 'numeric'],
            'phone' => ['nullable', 'regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/'],
            'address' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image'],
        ];
    }
}
