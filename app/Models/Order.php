<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    
    public $table = 'orders';

    protected $dates =  [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'customer_id',
        'session_id',
        'content',
        'type',
        'token',
        'sub_total',
        'item_discount',
        'tax',
        'shipping',
        'total',
        'discount',
        'grand_total',
        'name',
        'email',
        'phone',
        'address_line',
        'city',
        'postal_code',
        'country',
        'order_number',
        'payment_id',
        'order_date',
        'payment_date',
        'ship_date',
        'discount_id',
        'freight',
        'status'
    ];



    public function customer()
    {
        return $this->belongsTo('App\Models\User', 'customer_id', 'user_id');
    }

    public function payment() 
    {
        return $this->belongsTo('App\Models\Payment', 'payment_id', 'id');
    }

    public function shipper()
    {
        return $this->belongsTo('App\Models\Shipper', 'shipper_id', 'id');
    }

    public function order_item()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id');
    }

    public function discount()
    {
        return $this->belongsTo('App\Models\Discount', 'discount_id', 'id');
    }

    public function status()
    {
        return $this->hasMany('App\Models\OrderStatus', 'order_id');
    }

    public function shipment()
    {
        return $this->hasMany('App\Models\Shipment', 'order_id');
    }

}
