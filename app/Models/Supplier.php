<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;


    public $table = 'supplier';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'company_name',
        'contact_name',
        'contact_title',
        'address',
        'phone',
        'email',
        'payment_method',
        'discount_type',
        'type_goods',
        'notes',
        'logo',
        'customer_id',
    ];

    public function product()
    {
        return $this->hasMany('App\Models\Product', 'supplier_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\User', 'customer_id', 'user_id');
    }

}
