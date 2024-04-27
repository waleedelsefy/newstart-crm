<?php

namespace App\Policies;

use App\Models\Source;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SourcePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissions(['view-any-source']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Source $source): bool
    {
        return $user->hasPermissions(['view-source']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissions(['create-source']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Source $source): bool
    {
        return $user->hasPermissions(['update-source']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Source $source): bool
    {
        return $user->hasPermissions(['delete-source']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Source $source): bool
    {
        return $user->hasPermissions(['restore-source']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Source $source): bool
    {
        return $user->hasPermissions(['force-delete-source']);
    }
}
