<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\CartItem as CartItemResource;
use App\Http\Resources\Product\Product as ProductResource;


class Cart extends JsonResource
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
            'my_cart_items' => CartItemResource::collection($this->whenLoaded('my_cart_items')),
            'product' => ProductResource::collection($this->whenLoaded('product')),
            'session_id' => $this->session_id,
            'token' => $this->token ,
            'status' => $this->status,
            'content' => $this->content,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address_line' => $this->address_line,
            'city' =>$this->city,
            'postal_code' => $this->postal_code,
            'subtotal' => $this->subtotal,
            'country' => $this->country,
            'total' => $this->total
        ];
    }
}
