<?php

namespace App\Models\Policies;

use App\Models\Supplier;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupplierPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //

        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Supplier $supplier)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $userWithRole = $user->load('role');
        
            $userRole = new UserResource($userWithRole);
    
        $adminRole = false;

        foreach ($userRole->role as $role) {
            if ($role->name == 'customer') {
                $adminRole = true;
            }
        }

        if (isset($userRole->supplier)) 
        {
            $adminRole = false;
        }
        
        return $adminRole ;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Supplier $supplier)
    {
        $userWithRole = $user->load('role');
            $userRole = new UserResource($userWithRole);
        $adminRole = false;

        foreach ($userRole->role as $role) {
            if ($role->name == 'supplier') {
                $adminRole = true;
            }
        }
        
        return $adminRole  && $supplier->customer_id == $user->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Supplier $supplier)
    {
        $userWithRole = $user->load('role');
            $userRole = new UserResource($userWithRole);
        $adminRole = false;

        foreach ($userRole->role as $role) {
            if ($role->name == 'supplier') {
                $adminRole = true;
            }
        }
        
        return $adminRole  && $supplier->customer_id == $user->role;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Supplier $supplier)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Supplier $supplier)
    {
        //
    }
}
