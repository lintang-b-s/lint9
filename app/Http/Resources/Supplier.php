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
            'phone' => $this->phone,
            'product' => ProductResource::collection($this->whenLoaded('product')),
            'customer' => new UserResource($this->whenLoaded('customer')),
        ];
    }
}
