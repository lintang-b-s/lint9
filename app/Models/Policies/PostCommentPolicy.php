<?php

namespace App\Policies\..\Models\Policies;

use App\Models\PostComment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostCommentPolicy
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
     * @param  \App\Models\PostComment  $postComment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, PostComment $postComment)
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
        return true;

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostComment  $postComment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, PostComment $postComment)
    {
        //
        return $postComment->author_id === $user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostComment  $postComment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, PostComment $postComment)
    {
        //
        return $postComment->author_id === $user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostComment  $postComment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, PostComment $postComment)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PostComment  $postComment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, PostComment $postComment)
    {
        //
        return false;
    }
}
