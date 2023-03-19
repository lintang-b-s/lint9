<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    use HasFactory;

    public $table = 'shippers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'company_name',
        'phone'
    ];


    public function shipment_type()
    {
        return $this->hasMany('App\Models\ShipmentType', 'shipper_id');
    }
    
}
