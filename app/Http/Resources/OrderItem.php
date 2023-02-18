<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\Product\Product as ProductResource;
class OrderItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request,);
        return [
            'product_id' => $this->product_id,
            'price' => $this->price,
            'quantity'=> $this->quantity,
            'sku' => $this->sku,
            'discount' => $this->discount,
            'total' => $this->total,
            'size' => $this->size,
            'ship_date' => $this->ship_date,
            'delivered_date'=> $this->delivered_date,
            'order' => new OrderResource($this->whenLoaded('order')),
            'product' => new ProductResource($this->whenLoaded('product')),

        ];
    }
}
