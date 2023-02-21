<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Address extends JsonResource
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
        'address_line' => $this->address_line,
        'city' => $this->city,
        'postal_code' => $this->postal_code,
        'country' => $this->country
       ];
    }
}
