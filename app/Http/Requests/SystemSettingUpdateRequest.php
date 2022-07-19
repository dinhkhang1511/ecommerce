<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystemSettingUpdateRequest extends FormRequest
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
            'shop_name' => 'nullable',
            'site_title' => 'nullable',
            'favicon' => 'nullable|image',
            'logo' => 'nullable|image',
            'email' => 'nullable|email',
            'copyright_text' => 'nullable',
            'phone' => 'nullable|regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/',
            'province_id' => 'nullable',
            'district_id' => 'nullable',
            'ward_id' => 'nullable',
            'address' => 'nullable',
        ];
    }
}
