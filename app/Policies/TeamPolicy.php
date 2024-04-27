<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TeamPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissions(['view-any-team']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Team $team): bool
    {
        if (!$user->hasPermissions(['view-team'])) return false;
        return in_array(auth()->id(), [$team->leader->id, ...$team->members->pluck('id')->toArray()]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissions(['create-team']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Team $team): bool
    {
        if ($user->hasPermissions(['update-team'])) {

            if ($user->hasPermissions(['view-team-not-createdby-me'])) {
                return true;
            }

            return $user->id == $team->created_by;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Team $team): bool
    {
        if ($user->hasPermissions(['delete-team'])) {

            if ($user->hasPermissions(['view-team-not-createdby-me'])) {
                return true;
            }

            return $user->id == $team->created_by;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Team $team): bool
    {
        return $user->hasPermissions(['restore-team']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Team $team): bool
    {
        return $user->hasPermissions(['force-delete-team']);
    }
}
