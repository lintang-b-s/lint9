<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentStatus extends Model
{
    use HasFactory;

    public $table = 'shipment_statuses';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'title',
        'location',
        'status_date',
        'ship_id'
    ];

    public function shipment()
    {
        return $this->belongsTo('App\Models\Shipment', 'ship_id', 'id');
    }
}
