<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostTag extends Model
{
    // use HasFactory;
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'blog_post_id',
        'tag_id',
    ];

    public function post()
    {
        return $this->belongsTo('App\Models\BlogPost', 'blog_post_id', 'id');
    }

    public function tag()
    {
        return $this->belongsTo('App\Models\Tag', 'tag_id', 'id');
    }

}
