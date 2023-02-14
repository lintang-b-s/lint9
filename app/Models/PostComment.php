<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use SoftDeletes;

    public $table = 'post_comment';

    protected $fillable = [
        'post_id',
        'title',
        'content',
        'published',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function post()
    {
        return $this->belongsTo('App\Models\BlogPost', 'post_id', 'id');
    }
}
