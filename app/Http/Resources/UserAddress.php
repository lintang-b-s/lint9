<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User as UserResource;
class UserAddress extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('user')),
            'address_line' => $this->address_line,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'active' => $this->active
       ];
    }
}
