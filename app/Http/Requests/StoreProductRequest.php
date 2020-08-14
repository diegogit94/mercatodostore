<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|unique:products',
            'short_description' => 'required|min:2|max:200',
            'description' => 'required|min:2|max:200',
            'price' => 'required|numeric',
            'image' => 'required|mimes:jpeg,bmp,png,jpg'
        ];
    }
}
