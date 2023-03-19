<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    public $table = 'discounts';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = 
    [
        'name',
        'description',
        'discount_percent',
        'active'
    ];

    public function product()
    {
        return $this->hasMany('App\Models\Product', 'discount_id');
    }

    public function order()
    {
        return $this->hasMany('App\Models\Order', 'discount_id');
    }
}
