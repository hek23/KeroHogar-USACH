<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the order.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('driver');
    }

    /**
     * Determine whether the user can create orders.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the order.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the order.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can change the delivery status of the order.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function deliver(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('driver');
    }

    /**
     * Determine whether the user can change the payment status of the order.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function payment(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('driver');
    }
}
