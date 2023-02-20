<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;


    public $table = 'product_categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'category_name',
        'description',
        'picture',
        'active'
    ];

    // protected $primaryKey = 'id';//


    public function product()
    {
        return $this->belongsToMany('App\Models\Product', 'pivot_product_categories', 'category_id', 'product_id');
    }

    public function product_category()
    {
        return $this->hasMany('App\Models\PivotProductCategory', 'category_id');
    }



    
}
