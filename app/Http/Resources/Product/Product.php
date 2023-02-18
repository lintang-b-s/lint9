<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Supplier as SupplierResource;
use App\Http\Resources\Discount as DiscountResource;
use App\Http\Resources\ProductCategory as ProductCategoryResource;

use App\Http\Resources\OrderItem as OrderItemResource;

use App\Http\Resources\Cart as CartResource;
use App\Http\Resources\CartItem as CartItemResource;
use App\Http\Resources\ProductReview as ProductReviewResource;


class Product extends JsonResource
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
            'sku' => $this->sku,
            'idsku' => $this->idsku,
            'product_name' => $this->product_name,
            'meta_title' => $this->meta_title,
            'slug' => $this->slug,
            'product_description' => $this->product_description,
            'supplier' => new SupplierResource($this->whenLoaded('supplier')),
            'discount' => new DiscountResource($this->whenLoaded('discount')),
            'category' =>  ProductCategoryResource::collection($this->whenLoaded('category')),
            'order_item' =>  OrderItemResource::collection($this->whenLoaded('order_item')),
            'cart' =>  CartResource::collection($this->whenLoaded('cart')) ,
            'cart_item' =>  CartItemResource::collection($this->whenLoaded('cart_item')),
            'product_review' => ProductReviewResource::collection($this->whenLoaded('product_review')),
            'discount_id' => $this->discount_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'size' => $this->size,
            'discount' => $this->discount,
            'weight' => $this->weight,
            'picture' => $this->picture,
            'ranking' => $this->ranking,
            'sold' => $this->sold,
            'review_total' => $this->review_total,
        ];
    }
}
