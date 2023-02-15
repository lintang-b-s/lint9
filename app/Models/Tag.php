<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    // use HasFactory;
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'metaTitle',
        'slug',
        'content',
    ];

    public function post()
    {
        return $this->belongsToMany('App\Models\BlogPost');
    }

    public function post_tag()
    {
        return $this->hasMany('App\Models\PostTag', 'tag_id');
    }
}
