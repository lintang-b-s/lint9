<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    public $table = 'cart_items';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = 
    [
        'product_id',
        'cart_id',
        'sku',
        'price',
        'discount',
        'quantity',
        'active'
    ];

    public function product_id()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function cart_id()
    {
        return $this->belongsTo('App\Models\Cart', 'cart_id', 'id');
    }
}
