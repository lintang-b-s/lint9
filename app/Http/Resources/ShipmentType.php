<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Shipper as ShipperResource;
use App\Models\Shipment as ShipmentResource;

class ShipmentType extends JsonResource
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
            'name' => $this->name,
            'received_date_est' => $this->received_date_est,
            'packaging_cost' => $this->packaging_cost,
            'shipping_fee_wg' => $this->shipping_fee_wg,
            'shipping_fee_ds' => $this->shipping_fee_ds,
            'shipper' => new ShipperResource($this->whenLoaded('shipper')),
            'shipment' => ShipmentResource::collection($this->whenLoaded('shipment'))
        ];
    }
}
