<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowPlaceRequest extends FormRequest
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
            'city_card_id' => 'required',
            'type' => 'required',
            'name' => 'required',
            'description' => 'required',
            'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ];
    }
}
