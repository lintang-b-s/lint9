<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentType extends Model
{
    use HasFactory;

    public $table = 'shipment_types';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'received_date',
        'packaging_cost',
        'shipping_fee_wg',
        'shipping_fee_ds',
        'shipper_id'
    ];

    public function shipper()
    {
        return $this->belongsTo('App\Models\Shipper', 'shipper_id', 'id');
    }

    public function shipment()
    {
        return $this->hasMany('App\Models\Shipment', 'ship_type_id');
    }
}
