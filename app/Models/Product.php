<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public $table = 'product';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = 
    [
        'sku',
        'idsku',
        'product_name',
        'product_description',
        'supplier_id',
        'category_id',
        'quantity',
        'unit_price',
        'size',
        'discount',
        'weight',
        'picture',
        'ranking'
    ];


    public function category()
    {
        return $this->belongsTo('App\Models\PostCategory', 'category_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'supplier_id', 'id');
    }

    public function order_detail()
    {
        return $this->hasMany('App\Models\OrderDetail', 'product_id');
    }
}
