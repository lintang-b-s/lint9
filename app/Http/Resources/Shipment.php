<?php

namespace App\Http\Resources;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\ShipmentType as ShipmentTypeResource;
use App\Http\Resources\ShipmentStatus as ShipmentStatusResource;

use Illuminate\Http\Resources\Json\JsonResource;

class Shipment extends JsonResource
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
            'order' => new OrderResource($this->whenLoaded('order')),
            'shipment_type' => new ShipmentTypeResource($this->whenLoaded('shipment_type')),
            'shipment_status' => ShipmentStatusResource::collection($this->whenLoaded('shipment_status')),
            'supplier_id' => $this->supplier_id
        ];
    }
}
