<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Models\PostComment;


class BlogPost extends Model
{
    use SoftDeletes;

    public $table = 'blog_posts';

    protected $fillable = ['author_id', 'title'
    , 
    'meta_title',
     'slug', 'summary', 'content','published', 'thumbnail'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    //
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'user_id');
    }

    //
    public function tag()
    {
        return $this->belongsToMany('App\Models\Tag', 'post_tags', 'blog_post_id', 'tag_id');
    }


    public function post_tag()
    {
        return $this->hasMany('App\Models\PostTag', 'blog_post_id');
    }

    public function post_comment()
    {
        return $this->hasMany('App\Models\PostComment', 'post_id');
    }

    //
    public function category()
    {
        return $this->belongsToMany('App\Models\Category', 'post_categories', 'blog_post_id', 'category_id');
    }

    public function post_category()
    {
        return $this->hasMany('App\Models\PostCategory', 'blog_post_id');
    }

    

    public function scopeMostComment(Builder $query) 
    {
        return $query->latest()
            ->withCount('post_comment')
            ->with('author');
    }

   
}
