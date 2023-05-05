<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'city_id' => 'required',
            'user_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'duration' => 'required',
            'price' => 'required',
            'type' => 'required',
            'kind' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg',
        ];
    }
}
