<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuideVerificationRequest extends FormRequest
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
            'user_id' => 'nullable',
            'photo_certificate' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:10072',
            'photo_passport' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:10072',
            'photo_passport_with_selfie' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:10072'
        ];
    }
}
