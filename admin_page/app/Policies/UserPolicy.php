<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('driver');
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        // If they have the same role, he can't change anything of the other user.
        if($user->hasRole('admin')) {
            if($model->hasRole('admin')) {
                return $user->id === $model->id;
            }
            return $model->hasRole('driver');
        } else {
            return $user->id === $model->id;
        }
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $user->hasRole('admin') && $user->id !== $model->id;
    }
}
