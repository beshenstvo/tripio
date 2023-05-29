<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GuideVerificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'is_verified' => $this->is_verified,
            'photo_certificate' => $this->photo_certificate,
            'photo_passport' => $this->photo_passport,
            'photo_passport_with_selfie' => $this->photo_passport_with_selfie,
            'message_about_not_verified' => $this->message_about_not_verified,
            'user' => $this->user
        ];
    }
}
