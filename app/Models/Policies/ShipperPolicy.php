<?php

namespace App\Models\Policies;

use App\Models\Shipper;
use App\Models\User;
use App\Models\User as UserResource;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShipperPolicy
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
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shipper  $shipper
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Shipper $shipper)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //

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

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shipper  $shipper
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Shipper $shipper)
    {
        //

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

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shipper  $shipper
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Shipper $shipper)
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

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shipper  $shipper
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Shipper $shipper)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shipper  $shipper
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Shipper $shipper)
    {
        //
    }
}
