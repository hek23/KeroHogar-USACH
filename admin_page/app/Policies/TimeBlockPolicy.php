<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimeBlockPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the time block.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('driver');
    }

    /**
     * Determine whether the user can create time blocks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the time block.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the time block.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasRole('admin');
    }
}
