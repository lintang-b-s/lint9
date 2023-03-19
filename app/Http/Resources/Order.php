<?php

namespace App\Http\Resources;


use App\Http\Resources\User as UserResource;
use App\Http\Resources\Payment as PaymentResource;
use App\Http\Resources\Discount as DiscountResource;
use App\Http\Resources\OrderItem as OrderItemResource;
use App\Http\Resources\OrderStatus as OrderStatusResource;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
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
            'customer'  =>  new UserResource($this->whenLoaded('customer')),
            'content' => $this->content,
            'type' => $this->type,
            'sub_total' => $this->sub_total,
            'item_discount' => $this->item_discount,
            'tax' => $this->tax,
            'shipping' => $this->shipping,
            'total' => $this->total,
            'discount' => $this->discount,
            'grand_total' => $this->grand_total,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address_line' => $this->address_line,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'order_date' => $this->order_date,
            'payment_date' => $this->payment_date,
            'payment' => new PaymentResource($this->whenLoaded('payment')),
            'freight' => $this->freight,
            'discount' => new DiscountResource($this->whenLoaded('discount')),
            'order_item' => OrderItemResource::collection($this->whenLoaded('order_item')),
            'status' => OrderStatusResource::collection($this->whenLoaded('status')),

        ];
    }
}
