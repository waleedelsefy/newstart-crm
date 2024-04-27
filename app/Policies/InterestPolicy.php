<?php

namespace App\Policies;

use App\Models\Interest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InterestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissions(['view-any-interest']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Interest $interest): bool
    {
        return $user->hasPermissions(['view-interest']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissions(['create-interest']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Interest $interest): bool
    {
        return $user->hasPermissions(['update-interest']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Interest $interest): bool
    {
        return $user->hasPermissions(['delete-interest']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Interest $interest): bool
    {
        return $user->hasPermissions(['restore-interest']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Interest $interest): bool
    {
        return $user->hasPermissions(['force-delete-interest']);
    }
}
