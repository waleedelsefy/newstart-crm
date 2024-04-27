<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComparisonController extends Controller
{

    private $authUser = null;

    private $type = null;

    private $from_date_left = null;
    private $to_date_left = null;

    private $from_date_right = null;
    private $to_date_right = null;

    private $comparison_left = [];
    private $comparison_right = [];

    public function initialValues()
    {
        $this->authUser = Auth::user();

        $this->from_date_left = request()->get('from_date_left');
        $this->to_date_left = request()->get('to_date_left');

        $this->from_date_right = request()->get('from_date_right');
        $this->to_date_right = request()->get('to_date_right');
    }


    public function index(string $type)
    {
        $this->authorize('view-my-reports-reports');

        $this->type = $type;
        $this->initialValues();
        $this->compare();

        return view('pages.comparison.index', [
            'comparison_left' => $this->comparison_left,
            'comparison_right' => $this->comparison_right,
            'type' => $this->type,
        ]);
    }

    private function compare()
    {
        if ($this->type == 'leads') {
            $this->leads();
        }

        if ($this->type == 'events') {
            $this->events();
        }
    }


    private function filterLeft($query, $tableName = '')
    {
        // Date filters
        $from_date = $this->from_date_left ? Carbon::parse($this->from_date_left)->format('Y-m-d') : null;
        $to_date = $this->to_date_left ?  Carbon::parse($this->to_date_left)->format('Y-m-d') : null;
        $tableName = $tableName ? "$tableName." : '';

        if ($from_date)
            $query->whereDate("{$tableName}created_at", ">=", $from_date);
        if ($to_date)
            $query->whereDate("{$tableName}created_at", "<=", $to_date);
    }

    private function filterRight($query, $tableName = '')
    {
        // Date filters
        $from_date = $this->from_date_right ? Carbon::parse($this->from_date_right)->format('Y-m-d') : null;
        $to_date = $this->to_date_right ?  Carbon::parse($this->to_date_right)->format('Y-m-d') : null;
        $tableName = $tableName ? "$tableName." : '';

        if ($from_date)
            $query->whereDate("{$tableName}created_at", ">=", $from_date);
        if ($to_date)
            $query->whereDate("{$tableName}created_at", "<=", $to_date);
    }

    private function leads()
    {
        $this->comparison_left = DB::table('leads')
            ->selectRaw('leads.branch_id, branches.name AS label , COUNT(leads.branch_id) AS count')
            ->join('branches', 'leads.branch_id', '=', 'branches.id')
            ->where(fn ($query) => $this->filterLeft($query, 'leads'))
            ->where(function ($query) {
                if ($this->authUser->owner == 0) {
                    if ($this->authUser->hasRole('marketing', 'marketing-team-leader', '	marketing-manager')) {
                        $query->whereIn('created_by', [$this->authUser->id, ...$this->authUser->teamsMembersIDs()]);
                    } else {
                        $query->whereIn('assigned_to', [$this->authUser->id, ...$this->authUser->teamsMembersIDs()]);
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

        $this->comparison_right = DB::table('leads')
            ->selectRaw('leads.branch_id, branches.name AS label , COUNT(leads.branch_id) AS count')
            ->join('branches', 'leads.branch_id', '=', 'branches.id')
            ->where(fn ($query) => $this->filterRight($query, 'leads'))
            ->where(function ($query) {
                if ($this->authUser->owner == 0) {
                    if ($this->authUser->hasRole('marketing', 'marketing-team-leader', '	marketing-manager')) {
                        $query->whereIn('created_by', [$this->authUser->id, ...$this->authUser->teamsMembersIDs()]);
                    } else {
                        $query->whereIn('assigned_to', [$this->authUser->id, ...$this->authUser->teamsMembersIDs()]);
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
    }

    private function events()
    {

        $this->comparison_left = Lead::dashboardFilter(request()->query())
            ->where(fn ($query) => $this->filterLeft($query, 'leads'))
            ->where(function ($query) {
                if ($this->authUser->owner == 0) {
                    if ($this->authUser->hasRole('marketing', 'marketing-team-leader', 'marketing-manager')) {
                        $query->whereIn('created_by', [$this->authUser->id, ...$this->authUser->teamsMembersIDs()]);
                    } else {
                        $query->whereIn('assigned_to', [$this->authUser->id, ...$this->authUser->teamsMembersIDs()]);
                    }
                }
            })
            ->selectRaw('event AS label, count(event) as count')
            ->groupBy('event')->get();

        $this->comparison_right = Lead::dashboardFilter(request()->query())
            ->where(fn ($query) => $this->filterRight($query, 'leads'))
            ->where(function ($query) {
                if ($this->authUser->owner == 0) {
                    if ($this->authUser->hasRole('marketing', 'marketing-team-leader', 'marketing-manager')) {
                        $query->whereIn('created_by', [$this->authUser->id, ...$this->authUser->teamsMembersIDs()]);
                    } else {
                        $query->whereIn('assigned_to', [$this->authUser->id, ...$this->authUser->teamsMembersIDs()]);
                    }
                }
            })
            ->selectRaw('event AS label, count(event) as count')
            ->groupBy('event')->get();
    }
}
