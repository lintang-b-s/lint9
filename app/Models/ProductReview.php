<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;


    public $table = 'product_reviews';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = 
    [
        'customer_id',
        'product_id',
        'title',
        'rating',
        'published'
        
    ];


    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\User', 'customer_id' ,'user_id');
    }
}
