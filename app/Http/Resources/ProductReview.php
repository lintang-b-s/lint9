<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resource\Product\Product as ProductResource;

class ProductReview extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'customer' => new UserResource($this->whenLoaded('customer')),
            'product' => new ProductResource($this->whenLoaded('product')),
            'title' => $this->title,
            'rating' => $this->rating,
            'published' => $this->published
        ];
    }
}
