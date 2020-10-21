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
            'last_name' => 'required|min:2|max:70',
            'address' => 'required|min:6|max:100',
            'city' => 'required|min:6|max:50',
            'province' => 'required|min:6|max:50',
            'postal_code' => 'required|numeric',
            'phone' => 'required|numeric',
            'document_type' => 'required|',
            'document_number' => 'required|numeric'
        ];
    }
}
