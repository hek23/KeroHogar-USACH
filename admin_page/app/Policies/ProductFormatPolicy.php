<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductFormatPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the format.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('driver');
    }

    /**
     * Determine whether the user can create formats.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the format.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the format.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasRole('admin');
    }
}
