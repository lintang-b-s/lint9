<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public $table = 'carts';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = 
    [
        'customer_id',
        'session_id',
        'token',
        'status',
        'content',
        'name',
        'email',
        'phone',
        'address_line',
        'city',
        'postal_code',
        'country'
    ];


    public function cart_item()
    {
        return $this->hasMany('App\Models\CartItem', 'cart_id');
    }

    public function product()
    {
        return $this->belongsToMany('App\Models\Product', 'cart_items', 'cart_id', 'product_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\User', 'customer_id', 'user_id');
    }
    

}
