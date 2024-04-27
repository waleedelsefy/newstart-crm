<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use App\Models\Lead;
use App\Models\LeadHistory;
use App\Models\Project;
use App\Models\Source;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $this->authorize('view-reports');
        return view('pages.reports.index');
    }

    public function sales()
    {
        $this->authorize('view-sales-reports');

        $filters = request()->query();

        if (auth()->user()->owner) {
            $users = User::everySales();
        } elseif (auth()->user()->teamsILead->count() > 0) {
            $users = User::whereIn('id', [auth()->id(), ...auth()->user()->teamsMembersIDs()])->everySales();
        } else {
            $users = User::where('id', auth()->id())->everySales();
        }

        if (isset($filters['search']) && $filters['search'] != null) {
            $users = $users->where('name', 'LIKE', "%" . $filters['search'] . "%");
        }

        $users = $users->paginate(5)->withQueryString();

        return view('pages.reports.sales.index', compact('users'));
    }

    public function marketing()
    {
        $this->authorize('view-marketing-reports');

        $filters = request()->query();

        if (auth()->user()->owner) {
            $users = User::everyMarketing();
        } elseif (auth()->user()->teamsILead->count() > 0) {
            $users = User::whereIn('id', [auth()->id(), ...auth()->user()->teamsMembersIDs()])->everyMarketing();
        } else {
            $users = User::where('id', auth()->id())->everyMarketing();
        }

        if (isset($filters['search']) && $filters['search'] != null) {
            $users = $users->where('name', 'LIKE', "%" . $filters['search'] . "%");
        }

        $users = $users->paginate(5)->withQueryString();

        return view('pages.reports.marketing.index', compact('users'));
    }

    public function assign()
    {
        $this->authorize('view-assign-reports');

        $filters = request()->query();

        // Date and time filters
        $from_date = $filters['from_date'] ?? false ? Carbon::parse($filters['from_date'])->format('Y-m-d') : null;
        $to_date = $filters['to_date'] ?? false ? Carbon::parse($filters['to_date'])->format('Y-m-d') : null;
        $from_time = $filters['from_time'] ?? false ? Carbon::parse($filters['from_time'])->format('H:i:s') : null;
        $to_time = $filters['to_time'] ?? false ? Carbon::parse($filters['to_time'])->format('H:i:s') : null;

        if (auth()->user()->owner) {
            $users = User::everySales();
        } elseif (auth()->user()->hasPermissions(['view-unassigned-lead'])) {
            $users = User::whereHasPermission('available-for-assign-leads-to-him');
        } elseif (auth()->user()->teamsILead->count() > 0) {
            $users = User::whereIn('id', [auth()->id(), ...auth()->user()->teamsMembersIDs()])->everySales();
        } else {
            $users = User::where('id', auth()->id())->everySales();
        }

        if (isset($filters['search']) && $filters['search'] != null) {
            $users = $users->where('name', 'LIKE', "%" . $filters['search'] . "%");
        }

        $users = $users->whereHas('leadsAssignedToYou', function ($q) use ($from_date, $to_date, $from_time, $to_time) {
            if ($from_date)
                $q->whereDate("assigned_at", ">=", $from_date);
            if ($to_date)
                $q->whereDate("assigned_at", "<=", $to_date);
            if ($from_time)
                $q->whereTime("assigned_at", ">=", $from_time);
            if ($to_time)
                $q->whereTime("assigned_at", "<=", $to_time);
        })->with('leadsAssignedToYou', function ($q) use ($from_date, $to_date, $from_time, $to_time) {
            if ($from_date)
                $q->whereDate("assigned_at", ">=", $from_date);
            if ($to_date)
                $q->whereDate("assigned_at", "<=", $to_date);
            if ($from_time)
                $q->whereTime("assigned_at", ">=", $from_time);
            if ($to_time)
                $q->whereTime("assigned_at", "<=", $to_time);
        })->paginate(10)->withQueryString();


        return view("pages.reports.assign.index", compact('users'));
    }

    public function created()
    {
        $this->authorize('view-created-reports');

        $filters = request()->query();

        // Date and time filters
        $from_date = $filters['from_date'] ?? false ? Carbon::parse($filters['from_date'])->format('Y-m-d') : null;
        $to_date = $filters['to_date'] ?? false ? Carbon::parse($filters['to_date'])->format('Y-m-d') : null;
        $from_time = $filters['from_time'] ?? false ? Carbon::parse($filters['from_time'])->format('H:i:s') : null;
        $to_time = $filters['to_time'] ?? false ? Carbon::parse($filters['to_time'])->format('H:i:s') : null;



        if (auth()->user()->owner) {
            $users = User::whereHasPermission('create-lead');
        } elseif (auth()->user()->hasPermissions(['view-lead-not-createdby-me'])) {
            $users = User::whereHasPermission('create-lead');
        } elseif (auth()->user()->teamsILead->count() > 0) {
            $users = User::whereIn('id', [auth()->id(), ...auth()->user()->teamsMembersIDs()])->everyMarketing();
        } else {
            $users = User::where('id', auth()->id())->everyMarketing();
        }

        if (isset($filters['search']) && $filters['search'] != null) {
            $users = $users->where('name', 'LIKE', "%" . $filters['search'] . "%");
        }

        $users = $users->whereHas('leadsYouCreatedHistory', function ($q) use ($from_date, $to_date, $from_time, $to_time) {
            if ($from_date)
                $q->whereDate("created_at", ">=", $from_date);
            if ($to_date)
                $q->whereDate("created_at", "<=", $to_date);
            if ($from_time)
                $q->whereTime("created_at", ">=", $from_time);
            if ($to_time)
                $q->whereTime("created_at", "<=", $to_time);
        })->with('leadsYouCreatedHistory')->paginate(10)->withQueryString();


        return view("pages.reports.created.index", compact('users'));
    }

    public function myReports()
    {
        $this->authorize('view-my-reports-reports');

        $authUser = Auth::user();

        $leadsOfEachBranch = DB::table('leads')
            ->selectRaw('leads.branch_id, branches.name AS label , COUNT(leads.branch_id) AS count')
            ->join('branches', 'leads.branch_id', '=', 'branches.id')
            ->where(fn ($query) => $this->filter($query, 'leads'))
            ->where(function ($query) use ($authUser) {
                if ($authUser->owner == 0) {
                    if ($authUser->hasRole('marketing', 'marketing-team-leader', '	marketing-manager')) {
                        $query->whereIn('created_by', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    } else {
                        $query->whereIn('assigned_to', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    }
                }
            })
            ->groupBy('leads.branch_id')
            ->get()
            ->map(function ($item) {
                // Get name in current language
                $item->label = json_decode($item->label)->{app()->getLocale()};
                return $item;
            });

        $eventsCount = Lead::dashboardFilter(request()->query())
            ->where(function ($query) use ($authUser) {
                if ($authUser->owner == 0) {
                    if ($authUser->hasRole('marketing', 'marketing-team-leader', 'marketing-manager')) {
                        $query->whereIn('created_by', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    } else {
                        $query->whereIn('assigned_to', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    }
                }
            })
            ->selectRaw('event AS label, count(event) as count')
            ->groupBy('event')->get();

        return view('pages.reports.my-reports.index', compact('leadsOfEachBranch', 'eventsCount'));
    }

    public function sources()
    {
        $this->authorize('view-sources-reports');

        $authUser = auth()->user();

        $sources = Source::where(function ($query) {
            if (request()->get('search')) {
                $query->where('name', 'LIKE', '%' . request()->get('search') . '%');
            }
        })
            ->select(['id', 'name'])
            ->withCount(['leads' => function ($query) use ($authUser) {

                $query->where(fn ($query) => $this->filter($query, 'leads'));

                if ($authUser->owner == 0) {
                    if ($authUser->hasRole('marketing', 'marketing-team-leader', 'marketing-manager')) {
                        $query->whereIn('created_by', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    } else {
                        $query->whereIn('assigned_to', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    }
                }
            }])->paginate(10)->withQueryString();

        return view('pages.reports.sources.index', compact('sources'));
    }

    public function projects()
    {
        $this->authorize('view-projects-reports');

        $authUser = auth()->user();

        $projects = Project::where(function ($query) {
            if (request()->get('search')) {
                $query->where('name', 'LIKE', '%' . request()->get('search') . '%');
            }
        })
            ->select(['id', 'name'])
            ->withCount(['leads' => function ($query) use ($authUser) {

                $query->where(fn ($query) => $this->filter($query, 'leads'));

                if ($authUser->owner == 0) {
                    if ($authUser->hasRole('marketing', 'marketing-team-leader', 'marketing-manager')) {
                        $query->whereIn('created_by', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    } else {
                        $query->whereIn('assigned_to', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    }
                }
            }])->paginate(10)->withQueryString();


        return view('pages.reports.projects.index', compact('projects'));
    }

    public function interests()
    {
        $this->authorize('view-interests-reports');

        $authUser = auth()->user();

        $interests = Interest::where(function ($query) {
            if (request()->get('search')) {
                $query->where('name', 'LIKE', '%' . request()->get('search') . '%');
            }
        })
            ->select(['id', 'name'])
            ->withCount(['leads' => function ($query) use ($authUser) {

                $query->where(fn ($query) => $this->filter($query, 'leads'));

                if ($authUser->owner == 0) {
                    if ($authUser->hasRole('marketing', 'marketing-team-leader', 'marketing-manager')) {
                        $query->whereIn('created_by', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    } else {
                        $query->whereIn('assigned_to', [$authUser->id, ...$authUser->teamsMembersIDs()]);
                    }
                }
            }])->paginate(10)->withQueryString();


        return view('pages.reports.interests.index', compact('interests'));
    }

    private function filter($query, $tableName = '')
    {
        $filters = request()->query();

        // Date and time filters
        $from_date = $filters['from_date'] ?? false ? Carbon::parse($filters['from_date'])->format('Y-m-d') : null;
        $to_date = $filters['to_date'] ?? false ? Carbon::parse($filters['to_date'])->format('Y-m-d') : null;
        $from_time = $filters['from_time'] ?? false ? Carbon::parse($filters['from_time'])->format('H:i:s') : null;
        $to_time = $filters['to_time'] ?? false ? Carbon::parse($filters['to_time'])->format('H:i:s') : null;

        $tableName = $tableName ? "$tableName." : '';

        if ($from_date)
            $query->whereDate("{$tableName}created_at", ">=", $from_date);
        if ($to_date)
            $query->whereDate("{$tableName}created_at", "<=", $to_date);
        if ($from_time)
            $query->whereTime("{$tableName}created_at", ">=", $from_time);
        if ($to_time)
            $query->whereTime("{$tableName}created_at", "<=", $to_time);
    }
}
