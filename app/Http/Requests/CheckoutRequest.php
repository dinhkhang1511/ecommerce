<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'user_id' => 'nullable|numeric',
            'customer_name' => 'required',
            'customer_phone' => 'required|regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/',
            'customer_email' => 'required|email:rfc,dns',
            'customer_address' => 'required',
            'province_id' => 'required|numeric',
            'district_id' => 'required|numeric',
            'ward_id' => 'required|numeric',
            'notes' => 'nullable',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
        ];
    }
}
