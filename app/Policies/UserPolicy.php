<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Http\Resources\UserResource;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    public function store()
    {
        return true;
    }
    
    public function create()
    {
        return true;
    }

    public function addRole(User $user)
    {
        $userWithRole = $user->load('role');
            $userRole = new UserResource($userWithRole);
        $adminRole = false;

        foreach ($userRole->role as $role) {
            if ($role->name == 'superadmin') {
                $adminRole = true;
            }
        }
        
        return $adminRole ;
    }
}
