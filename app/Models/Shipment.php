<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    public $table = 'shipments';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'resi',
        'ship_type_id',
        'supplier_id',
        'order_id',
    ];

    public function shipment_type()
    {
        return $this->belongsTo('App\Models\ShipmentType', 'ship_type_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');

    }

    public function shipment_status()
    {
        return $this->hasMany('App\Models\ShipmentStatus', 'ship_id');
    }
}
