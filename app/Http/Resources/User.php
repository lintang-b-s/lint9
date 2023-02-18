<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Role as RoleResource;

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
            'role' => RoleResource::collection($this->whenLoaded('role')),
            
            'phone' => $this->phone,
          
        ];
    }
}
