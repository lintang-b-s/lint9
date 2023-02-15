<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    public $table = 'order_detail';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'product_id',
        'order_number',
        'price',
        'quantity',
        'discount',
        'total',
        'idsku',
        'size',
        'ship_date',
        'status',
        'order_id',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    
}
