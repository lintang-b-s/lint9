<?php

namespace App\Models;

class Role extends BaseModel
{
    /**
     * Role constants
     */
    public const ROLE_ADMIN = 'superadmin';

    /**
     * @var int Auto increments integer key
     */
    public $primaryKey = 'role_id';

    /**
     * @var string UUID key
     */
    public $uuidKey = 'role_uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description',
    ];

    public function user()
    {
        return $this->belongsToMany('App\Models\User', 'user_roles', 'role_id', 'user_id');
    }

    public function user_role()
    {
        return $this->hasMany('App\Models\RoleUser', 'role_id');
    }
}
