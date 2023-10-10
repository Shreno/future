<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'description' => $this->description,
            'phone' => $this->phone,
            'city' => ($this->city_id) ? $this->city->title : '',
            'region' => ($this->region_id) ? $this->region->title : '',

            'longitude' => $this->longitude,
            'latitude' => $this->latitude,

        ];
    }
}
