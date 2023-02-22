<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Product\Product as ProductResource;
use App\Http\Resources\Cart as CartResource;

class CartItem extends JsonResource
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
            'product' => new ProductResource($this->whenLoaded('product')),
            // 'cart' => new CartResource($this->whenLoaded('cart')),
            'sku' => $this->sku,
            'price' => $this->price,
            'discount' => $this->discount,
            'quantity' => $this->quantity,
            'active' => $this->active,
            'note' => $this->note
        ];
    }
}
