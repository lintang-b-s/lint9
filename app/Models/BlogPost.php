<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;

    public $table = 'blog_post';

    protected $fillable = ['author_id', 'title'
    , 'metaTitle', 'slug', 'summary', 'content','published'];

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
        return $this->belongsToMany('App\Models\Tag');
    }


    public function post_tag()
    {
        return $this->hasMany('App\Models\PostTag', 'blog_post_id');
    }

    //
    public function post_comment()
    {
        return $this->hasMany('App\Models\PostComment', 'post_id');
    }

    //
    public function post_category()
    {
        return $this->hasMany('App\Models\PostCategory', 'blog_post_id');
    }

    public function category()
    {
        return $this->belongsToMany('App\Models\PostCategory');
    }
    
}
