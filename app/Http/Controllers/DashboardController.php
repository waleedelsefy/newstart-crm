<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Developer;
use App\Models\Event;
use App\Models\Interest;
use App\Models\Lead;
use App\Models\LeadHistory;
use App\Models\Project;
use App\Models\Source;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $usersAvailableToAssign = [];

        if (auth()->user()->owner || auth()->user()->hasPermissions(['view-unassigned-lead'])) {
            $usersAvailableToAssign = User::availableToAssign()->get();
        } else {
            $usersAvailableToAssign = User::whereIn('id', auth()->user()->teamsMembersIDs())->availableToAssign()->get();
        }

        $creators = [];

        if (auth()->user()->owner || auth()->user()->hasPermissions(['view-unassigned-lead'])) {
            $creators = User::canCreateLeads()->get();
        } else {
            $creators = User::whereIn('id', auth()->user()->teamsMembersIDs())->get();
        }

        // Employees statstics (Users)

        $employeesCount = User::where('branch_id', auth()->user()->branch_id)->dashboardFilter(request()->query())->count();
        $ownersCount = User::where('branch_id', auth()->user()->branch_id)->dashboardFilter(request()->query())->owners()->count();
        $adminsCount = User::where('branch_id', auth()->user()->branch_id)->dashboardFilter(request()->query())->admins()->count();
        $marketingCount = User::where('branch_id', auth()->user()->branch_id)->dashboardFilter(request()->query())->marketing()->count();
        $salesManagersCount = User::where('branch_id', auth()->user()->branch_id)->dashboardFilter(request()->query())->salesManagers()->count();
        $teamLeadersCount = User::where('branch_id', auth()->user()->branch_id)->dashboardFilter(request()->query())->salesTeamLeaders()->count();
        $salesCount = User::where('branch_id', auth()->user()->branch_id)->dashboardFilter(request()->query())->sales()->count();
        $seniorSalesCount = User::where('branch_id', auth()->user()->branch_id)->dashboardFilter(request()->query())->seniorSales()->count();
        $juniorSalesCount = User::where('branch_id', auth()->user()->branch_id)->dashboardFilter(request()->query())->juniorSales()->count();

        // Leads statstics
        $authUser = auth()->user();
        if ($authUser->owner) {
            $leadsCount = Lead::where('branch_id', auth()->user()->branch_id)->filter(request()->query())->dashboardFilter(request()->query())->count();
        } else {
            $leadsCount = Lead::where('branch_id', auth()->user()->branch_id)->permissionsFilter()->filter(request()->query())->count();
        }

        $leadsAssignedByYou = Lead::where('branch_id', auth()->user()->branch_id)
            ->dashboardFilter(request()->query())
            ->where('assigned_by', $authUser->id)
            ->count();

        $teamsCount = Team::dashboardFilter(request()->query())->count();
        $teamsILeadCount = auth()->user()->teamsILead()->dashboardFilter(request()->query())->count();
        $teamsIMemberCount = auth()->user()->teamsIMember()->dashboardFilter(request()->query())->count();

        // Events statstics



        $eventsCount = Lead::where('branch_id', auth()->user()->branch_id)->filter(request()->query())->dashboardFilter(request()->query())
            ->whereNot('event', 'no-action')
            ->where(function ($query) use ($authUser) {
                if ($authUser->owner == 0) {

                    if (auth()->user()->hasRole('junior-sales', 'senior-sales')) {
                        return $query->where('assigned_to', $authUser->id);
                    }

                    if (auth()->user()->hasRole('marketing')) {
                        return $query->where('created_by', $authUser->id);
                    }

                    if (auth()->user()->hasRole('junior-sales', 'senior-sales', 'sales-team-leader', 'sales-manager')) {
                        $assigned_to = request()->get('assigned_to');

                        if ($assigned_to == 'me') {
                            return $query->where('assigned_to', $authUser->id);
                        }

                        if ($assigned_to == 'my_team') {
                            return $query->whereIn('assigned_to', $authUser->teamsMembersIDs());
                        }

                        if ($assigned_to == 'me_my_team' || is_null($assigned_to)) {
                            return $query->whereIn('assigned_to', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                        }
                    }

                    if (auth()->user()->hasRole('marketing-team-leader', 'marketing-manager')) {
                        $created_by = request()->get('created_by');

                        if ($created_by == 'me') {
                            return $query->where('created_by', $authUser->id);
                        }

                        if ($created_by == 'my_team') {
                            return $query->whereIn('created_by', $authUser->teamsMembersIDs());
                        }

                        if ($created_by == 'me_my_team' || is_null($created_by)) {
                            return $query->whereIn('created_by', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                        }
                    }
                }
            })
            ->selectRaw('event, count(event) as count')->groupBy('event')->get()
            ->filter(function ($lead) use ($authUser) {
                $eventName = Str::slug($lead->event);
                $eventPermissionName = strtolower("view-event-" . $eventName . "-dashboard");

                return $authUser->hasPermissions([$eventPermissionName]);
            });

        $noActionCount = Lead::where('branch_id', auth()->user()->branch_id)->filter(request()->query())->dashboardFilter(request()->query())->where('event', 'no-action')->where(function ($query) use ($authUser) {
            if ($authUser->owner == 0) {

                if (auth()->user()->hasRole('junior-sales', 'senior-sales')) {
                    return $query->where('assigned_to', $authUser->id);
                }

                if (auth()->user()->hasRole('marketing')) {
                    return $query->where('created_by', $authUser->id);
                }

                if (auth()->user()->hasRole('sales-team-leader', 'sales-manager')) {
                    $assigned_to = request()->get('assigned_to');

                    if ($assigned_to == 'me') {
                        return $query->where('assigned_to', $authUser->id);
                    }

                    if ($assigned_to == 'my_team') {
                        return $query->whereIn('assigned_to', $authUser->teamsMembersIDs());
                    }

                    if ($assigned_to == 'me_my_team' || is_null($assigned_to)) {
                        return $query->whereIn('assigned_to', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    }
                }

                if (auth()->user()->hasRole('marketing-team-leader', 'marketing-manager')) {
                    $created_by = request()->get('created_by');


                    if ($created_by == 'me') {
                        return $query->where('created_by', $authUser->id);
                    }

                    if ($created_by == 'my_team') {
                        return $query->whereIn('created_by', $authUser->teamsMembersIDs());
                    }

                    if ($created_by == 'me_my_team' || is_null($created_by)) {
                        return $query->whereIn('created_by', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    }
                }
            }
        })->count();


        // Today, Upcoming, Delay

        $leadsTodayCount = Lead::where('branch_id', auth()->user()->branch_id)->filter(request()->query())->dashboardFilter(request()->query())->where('reminder', 'today')->where(function ($query) use ($authUser) {
            if ($authUser->owner == 0) {

                if (auth()->user()->hasRole('junior-sales', 'senior-sales')) {
                    return $query->where('assigned_to', $authUser->id);
                }

                if (auth()->user()->hasRole('marketing')) {
                    return $query->where('created_by', $authUser->id);
                }

                if (auth()->user()->hasRole('sales-team-leader', 'sales-manager')) {
                    $assigned_to = request()->get('assigned_to');

                    if ($assigned_to == 'me') {
                        return $query->where('assigned_to', $authUser->id);
                    }

                    if ($assigned_to == 'my_team') {
                        return $query->whereIn('assigned_to', $authUser->teamsMembersIDs());
                    }

                    if ($assigned_to == 'me_my_team' || is_null($assigned_to)) {
                        return $query->whereIn('assigned_to', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    }
                }

                if (auth()->user()->hasRole('marketing-team-leader', 'marketing-manager')) {
                    $created_by = request()->get('created_by');


                    if ($created_by == 'me') {
                        return $query->where('created_by', $authUser->id);
                    }

                    if ($created_by == 'my_team') {
                        return $query->whereIn('created_by', $authUser->teamsMembersIDs());
                    }

                    if ($created_by == 'me_my_team' || is_null($created_by)) {
                        return $query->whereIn('created_by', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    }
                }
            }
        })->count();

        $leadsUpcomingCount = Lead::where('branch_id', auth()->user()->branch_id)->filter(request()->query())->dashboardFilter(request()->query())->where('reminder', 'upcoming')->where(function ($query) use ($authUser) {
            if ($authUser->owner == 0) {


                if (auth()->user()->hasRole('junior-sales', 'senior-sales')) {
                    return $query->where('assigned_to', $authUser->id);
                }

                if (auth()->user()->hasRole('marketing')) {
                    return $query->where('created_by', $authUser->id);
                }


                if (auth()->user()->hasRole('sales-team-leader', 'sales-manager')) {
                    $assigned_to = request()->get('assigned_to');

                    if ($assigned_to == 'me') {
                        return $query->where('assigned_to', $authUser->id);
                    }

                    if ($assigned_to == 'my_team') {
                        return $query->whereIn('assigned_to', $authUser->teamsMembersIDs());
                    }

                    if ($assigned_to == 'me_my_team' || is_null($assigned_to)) {
                        return $query->whereIn('assigned_to', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    }
                }


                if (auth()->user()->hasRole('marketing-team-leader', 'marketing-manager')) {
                    $created_by = request()->get('created_by');


                    if ($created_by == 'me') {
                        return $query->where('created_by', $authUser->id);
                    }

                    if ($created_by == 'my_team') {
                        return $query->whereIn('created_by', $authUser->teamsMembersIDs());
                    }

                    if ($created_by == 'me_my_team' || is_null($created_by)) {
                        return $query->whereIn('created_by', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    }
                }
            }
        })->count();

        $leadsDelayCount = Lead::where('branch_id', auth()->user()->branch_id)->filter(request()->query())->dashboardFilter(request()->query())->where('reminder', 'delay')->where(function ($query) use ($authUser) {
            if ($authUser->owner == 0) {

                if (auth()->user()->hasRole('junior-sales', 'senior-sales')) {
                    return $query->where('assigned_to', $authUser->id);
                }

                if (auth()->user()->hasRole('marketing')) {
                    return $query->where('created_by', $authUser->id);
                }


                if (auth()->user()->hasRole('sales-team-leader', 'sales-manager')) {
                    $assigned_to = request()->get('assigned_to');

                    if ($assigned_to == 'me') {
                        return $query->where('assigned_to', $authUser->id);
                    }

                    if ($assigned_to == 'my_team') {
                        return $query->whereIn('assigned_to', $authUser->teamsMembersIDs());
                    }

                    if ($assigned_to == 'me_my_team' || is_null($assigned_to)) {
                        return $query->whereIn('assigned_to', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    }
                }

                if (auth()->user()->hasRole('marketing-team-leader', 'marketing-manager')) {
                    $created_by = request()->get('created_by');


                    if ($created_by == 'me') {
                        return $query->where('created_by', $authUser->id);
                    }

                    if ($created_by == 'my_team') {
                        return $query->whereIn('created_by', $authUser->teamsMembersIDs());
                    }

                    if ($created_by == 'me_my_team' || is_null($created_by)) {
                        return $query->whereIn('created_by', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    }
                }
            }
        })->count();

        // System statstics

        $systemBranchesCount = Branch::dashboardFilter(request()->query())->count();
        $systemProjectsCount = Project::dashboardFilter(request()->query())->count();
        $systemDevelopersCount = Developer::dashboardFilter(request()->query())->count();
        $systemInterestsCount = Interest::dashboardFilter(request()->query())->count();
        $systemSourcesCount = Source::dashboardFilter(request()->query())->count();
        $systemEventsCount = Event::dashboardFilter(request()->query())->count();

        return view('pages.dashboard', [
            'usersAvailableToAssign' => $usersAvailableToAssign,
            'creators' => $creators,


            'employeesCount' => $employeesCount,
            'ownersCount' => $ownersCount,
            'adminsCount' => $adminsCount,
            'marketingCount' => $marketingCount,
            'salesManagersCount' => $salesManagersCount,
            'teamLeadersCount' => $teamLeadersCount,
            'salesCount' => $salesCount,
            'seniorSalesCount' => $seniorSalesCount,
            'juniorSalesCount' => $juniorSalesCount,


            'leadsCount' => $leadsCount,
            'leadsAssignedByYou' => $leadsAssignedByYou,
            'teamsCount' => $teamsCount,
            'teamsILeadCount' => $teamsILeadCount,
            'teamsIMemberCount' => $teamsIMemberCount,


            'eventsCount' => $eventsCount,
            'noActionCount' =>  $noActionCount,
            'leadsTodayCount' => $leadsTodayCount,
            'leadsUpcomingCount' => $leadsUpcomingCount,
            'leadsDelayCount' => $leadsDelayCount,


            'systemBranchesCount' =>  $systemBranchesCount,
            'systemProjectsCount' =>  $systemProjectsCount,
            'systemDevelopersCount' =>  $systemDevelopersCount,
            'systemInterestsCount' =>  $systemInterestsCount,
            'systemSourcesCount' =>  $systemSourcesCount,
            'systemEventsCount' =>  $systemEventsCount,

        ]);
    }

    public function changeBranch(Request $request)
    {
        $this->authorize('change-current-branch');
        auth()->user()->update(['branch_id' => $request->branch_id]);
        return redirect()->back();
    }
}
