<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LeadPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissions(['view-any-lead']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Lead $lead): bool
    {
        if ($user->hasPermissions(['view-lead'])) {

            if ($user->hasRole('admin', 'marketing-manager', 'marketing-team-leader', 'marketing')) {

                // View leads from all branches.

                if ($user->hasPermissions(['view-lead-from-all-branches'])) {
                    if ($user->hasPermissions(['view-lead-not-createdby-me'])) {
                        return true;
                    }

                    if ($user->hasPermissions(['view-team-member-lead'])) {
                        return $lead->created_by == $user->id ||
                            in_array($lead->created_by, $user->teamsMembersIDs());
                    }

                    return $lead->created_by == $user->id;
                }

                // View leads from his branch only.

                if (in_array($lead->branch_id, $user->branches->pluck('id')->toArray())) {
                    if ($user->hasPermissions(['view-lead-not-createdby-me'])) {
                        return true;
                    }

                    if ($user->hasPermissions(['view-team-member-lead'])) {
                        return $lead->created_by == $user->id ||
                            in_array($lead->created_by, $user->teamsMembersIDs());
                    }

                    return $lead->created_by == $user->id;
                }

                return false;
            } elseif ($user->hasRole('sales-manager', 'sales-team-leader', 'senior-sales', 'junior-sales')) {

                // View leads from all branches.

                if ($user->hasPermissions(['view-lead-from-all-branches'])) {
                    if ($user->hasPermissions(['view-unassigned-lead'])) {
                        return true;
                    }

                    if ($user->hasPermissions(['view-team-member-lead'])) {
                        return $lead->assigned_to == $user->id ||
                            in_array($lead->assigned_to, $user->teamsMembersIDs());
                    }

                    return $lead->assigned_to == $user->id;
                }

                // View leads from his branch only.


                if (in_array($lead->branch_id, $user->branches->pluck('id')->toArray())) {
                    if ($user->hasPermissions(['view-unassigned-lead'])) {
                        return true;
                    }

                    if ($user->hasPermissions(['view-team-member-lead'])) {
                        return $lead->assigned_to == $user->id ||
                            in_array($lead->assigned_to, $user->teamsMembersIDs());
                    }

                    return $lead->assigned_to == $user->id;
                }

                return false;
            } else {
                return true;
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
        return $user->hasPermissions(['create-lead']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Lead $lead): bool
    {
        if ($user->hasPermissions(['update-lead'])) {

            if ($user->hasRole('admin', 'marketing-manager', 'marketing-team-leader', 'marketing')) {

                // View leads from all branches.

                if ($user->hasPermissions(['view-lead-from-all-branches'])) {
                    if ($user->hasPermissions(['view-lead-not-createdby-me'])) {
                        return true;
                    }

                    if ($user->hasPermissions(['view-team-member-lead'])) {
                        return $lead->created_by == $user->id ||
                            in_array($lead->created_by, $user->teamsMembersIDs());
                    }

                    return $lead->created_by == $user->id;
                }

                // View leads from his branch only.

                if (in_array($lead->branch_id, $user->branches->pluck('id')->toArray())) {
                    if ($user->hasPermissions(['view-lead-not-createdby-me'])) {
                        return true;
                    }

                    if ($user->hasPermissions(['view-team-member-lead'])) {
                        return $lead->created_by == $user->id ||
                            in_array($lead->created_by, $user->teamsMembersIDs());
                    }

                    return $lead->created_by == $user->id;
                }

                return false;
            } elseif ($user->hasRole('sales-manager', 'sales-team-leader', 'senior-sales', 'junior-sales')) {

                // View leads from all branches.

                if ($user->hasPermissions(['view-lead-from-all-branches'])) {
                    if ($user->hasPermissions(['view-unassigned-lead'])) {
                        return true;
                    }

                    if ($user->hasPermissions(['view-team-member-lead'])) {
                        return $lead->assigned_to == $user->id ||
                            in_array($lead->assigned_to, $user->teamsMembersIDs());
                    }

                    return $lead->assigned_to == $user->id;
                }

                // View leads from his branch only.


                if (in_array($lead->branch_id, $user->branches->pluck('id')->toArray())) {
                    if ($user->hasPermissions(['view-unassigned-lead'])) {
                        return true;
                    }

                    if ($user->hasPermissions(['view-team-member-lead'])) {
                        return $lead->assigned_to == $user->id ||
                            in_array($lead->assigned_to, $user->teamsMembersIDs());
                    }

                    return $lead->assigned_to == $user->id;
                }

                return false;
            } else {
                return true;
            }

            return false;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Lead $lead): bool
    {
        return $user->hasPermissions(['delete-lead']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Lead $lead): bool
    {
        return $user->hasPermissions(['restore-lead']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Lead $lead): bool
    {
        return $user->hasPermissions(['force-delete-lead']);
    }

    public function changeLeadEvent(User $user, Lead $lead)
    {
        if ($user->hasPermissions(['change-lead-event'])) {
            if ($user->hasPermissions(['change-unassigned-lead-event']))
                return true;

            if ($user->hasPermissions(['change-team-member-lead-event'])) {
                return $lead->assigned_to == $user->id ||
                    in_array($lead->assigned_to, $user->teamsMembersIDs());
            }

            return $lead->assigned_to == $user->id;
        }
        return false;
    }

    public function viewLeadDuplicates(User $user, Lead $lead)
    {
        if ($user->hasPermissions(['view-lead-duplicates'])) {
            if ($user->hasPermissions(['view-unassigned-lead-duplicates']))
                return true;

            if ($user->hasPermissions(['view-team-member-lead-duplicates'])) {
                return $lead->assigned_to == $user->id ||
                    in_array($lead->assigned_to, $user->teamsMembersIDs());
            }

            return $lead->assigned_to == $user->id;
        }

        return false;
    }
}
