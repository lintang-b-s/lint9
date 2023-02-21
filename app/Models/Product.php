<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public $table = 'products';

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
        'meta_title',
        'slug',
        'product_description',
        'supplier_id',
        'discount_id',
        'quantity',
        'unit_price',
        'size',
        'weight',
        'picture',
        'ranking',
        'sold',
        'review_total',
    ];

    // public $sortable = ['name',
    // 'updated_at',
    // 'created_at',
    // 'unit_price',
    // ];

    // protected $primaryKey = 'id';//

   

    public function category() 
    {
        return $this->belongsToMany('App\Models\ProductCategory', 'pivot_product_categories', 'product_id', 'category_id');
    }

    public function product_category()
    {
        return $this->hasMany('App\Models\PivotProductCategory', 'product_id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'supplier_id', 'id');
    }

    public function order_item()
    {
        return $this->hasMany('App\Models\OrderItem', 'product_id');
    }

    public function discount()
    {
        return $this->belongsTo('App\Models\Discount', 'discount_id', 'id');
    }

    public function my_cart_items()
    {
        return $this->hasMany('App\Models\CartItem', 'product_id');
    }

    public function cart()
    {

        return $this->belongsToMany('App\Models\Cart', 'cart_items', 'product_id', 'cart_id');
    }

    public function product_review()
    {
        return $this->hasMany('App\Models\ProductReview', 'product_id');
    }


}
