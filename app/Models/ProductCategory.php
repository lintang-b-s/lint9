<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;


    public $table = 'product_category';

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

    public function product()
    {
        return $this->hasMany('App\Models\Product', 'category_id');
    }

    
}
