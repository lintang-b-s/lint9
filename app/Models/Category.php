<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $table = 'category';

    protected $fillable = [
        'title',
        'metaTitle',
        'slug',
        'content'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function post()
    {
        return $this->belongsToMany('App\Models\BlogPost');
    }

    public function post_category()
    {
        return $this->hasMany('App\Models\PostCategory', 'category_id');
    }

}
