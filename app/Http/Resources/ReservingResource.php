<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservingResource extends JsonResource
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
            'person_id' => $this->person_id,
            'room_id' => $this->room_id,
            'type_food' => $this->type_food,
            'arrival_time' => $this->arrival_time,
            'departure_time' => $this->departure_time
        ];
    }
}
