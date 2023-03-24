<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservingRequest extends FormRequest
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
            'person_id' => 'required',
            'room_id' => 'required',
            'type_food' => 'required',
            'arrival_time' => 'required',
            'departure_time' => 'required'
        ];
    }
}
