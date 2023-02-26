<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

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
