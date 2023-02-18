<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->name,
            'email' => $this->email,
            'is_admin' => $this->is_admin,
            'address' => $this->address,
            'phone' => $this->phone,
            'credit_card_type' => $this->credit_card_type
        ];
    }
}
