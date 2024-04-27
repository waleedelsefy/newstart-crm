<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissions(['view-any-user']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $userModel): bool
    {
        if ($user->hasPermissions(['view-user'])) {

            if ($user->hasPermissions(['view-user-from-all-branches'])) {

                if ($user->hasPermissions(['view-user-not-createdby-me'])) {
                    return true;
                }

                return $user->id == $userModel->created_by;
            }

            /**
             * check if one of auth user branches in user model branches.
             * if there's result this means that true.
             */
            $checkUserBranches = $user->branches->whereIn('id', $userModel->branches->pluck('id')->toArray())->count();

            if ($checkUserBranches) {

                if ($user->hasPermissions(['view-user-not-createdby-me'])) {
                    return true;
                }

                return $user->id == $userModel->created_by;
            }

            return false;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissions(['create-user']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->hasPermissions(['update-user']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->hasPermissions(['delete-user']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasPermissions(['restore-user']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasPermissions(['force-delete-user']);
    }
}
