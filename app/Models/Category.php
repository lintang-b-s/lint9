<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $table = 'categories';

    protected $fillable = [
        'title',
        'meta_title',
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
        return $this->belongsToMany('App\Models\BlogPost', 'post_categories', 'category_id', 'blog_post_id');
    }

    public function post_category()
    {
        return $this->hasMany('App\Models\PostCategory', 'category_id');
    }

    // public function scopeMostPost(Builder $query) 
    // {
    //    return $query ->withCount('post_comment')
    //         ->with('author');
    // }

}
