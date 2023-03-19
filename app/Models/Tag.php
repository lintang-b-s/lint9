<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    // use HasFactory;
    use SoftDeletes;

    public $table = 'tags';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'meta_title',
        'slug',
        'content',
    ];

    public function post()
    {
        return $this->belongsToMany('App\Models\BlogPost', 'post_tags', 'tag_id', 'blog_post_id');
    }

    public function post_tag()
    {
        return $this->hasMany('App\Models\PostTag', 'tag_id');
    }
}
