<?php

namespace App\Models\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

use App\Http\Resources\User as UserResource;

class ProductPolicy
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Product $product)
    {
        //
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
        //
        $userWithRole = $user->load('role');
         $userRole = new UserResource($userWithRole);
        $adminRole = false;

        foreach ($userRole->role as $role) {
            if ($role->name == 'supplier') {
                $adminRole = true;
            }
        }
        
        return $adminRole  ;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Product $product)
    {
        
        $userWithRole = $user->load('role');
         $userRole = new UserResource($userWithRole);
        $adminRole = false;

        foreach ($userRole->role as $role) {
            if ($role->name == 'supplier') {
                $adminRole = true;
            }
        }
        
        return $adminRole  && $product->load('supplier')->supplier->customer_id == $user->user_id;

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Product $product)
    {
    //
            $userWithRole = $user->load('role');
            $userRole = new UserResource($userWithRole);
        $adminRole = false;

        foreach ($userRole->role as $role) {
            if ($role->name == 'supplier') {
                $adminRole = true;
            }
        }
        
        return $adminRole  && $product->load('supplier')->supplier->customer_id == $user->user_id;

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Product $product)
    {
       //
       $userWithRole = $user->load('role');
       $userRole = new UserResource($userWithRole);
      $adminRole = false;

      foreach ($userRole->role as $role) {
          if ($role->name == 'supplier') {
              $adminRole = true;
          }
      }
      
      return $adminRole  && $product->load('supplier')->supplier->customer_id == $user->user_id;

    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Product $product)
    {
         //
         $userWithRole = $user->load('role');
         $userRole = new UserResource($userWithRole);
        $adminRole = false;

        foreach ($userRole->role as $role) {
            if ($role->name == 'supplier') {
                $adminRole = true;
            }
        }
        
        return $adminRole  && $product->load('supplier')->supplier->customer_id == $user->user_id;

    }
}
