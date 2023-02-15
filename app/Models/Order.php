<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    
    public $table = 'order';

    protected $dates =  [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'customer_id',
        'order_number',
        'payment_id',
        'order_date',
        'payment_date',
        'ship_date',
        'delivered_date',
        'cancel_date',
        'return_date',
        'return_reason',
        'shipper_id',
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

    public function order_detail()
    {
        return $this->hasMany('App\Models\OrderDetail', 'order_id');
    }

}
