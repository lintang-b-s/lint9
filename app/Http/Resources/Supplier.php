<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Product\Product as ProductResource;
use App\Http\Resources\User as UserResource;

class Supplier extends JsonResource
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
            'company_name' => $this->company_name,
            'contact_name' => $this->contact_name,
            'contact_title'=> $this->contact_title,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'type_goods' => $this->type_goods,
            'notes' => $this->notes,
            'logo' => $this->logo,
            'phone' => $this->phone,
            'product' => ProductResource::collection($this->whenLoaded('product')),
            'customer' => new UserResource($this->whenLoaded('customer')),
        ];
    }
}
