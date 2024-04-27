<?php

namespace App\Models;

use App\Traits\Dashboard;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class Lead extends Model
{
    use HasFactory, Dashboard;

    protected $fillable = [
        'name',
        'notes',
        'branch_id',
        'event',
        'reminder',
        'reminder_date',
        'event_created_by',
        'event_created_at',
        'assigned_by',
        'assigned_to',
        'assigned_at',
        'created_by',
    ];

    protected $casts = [
        'event_created_at' => 'datetime',
        'reminder_date' =>  'datetime',
    ];

    public static function booted(): void
    {
        static::creating(function (Lead $lead) {
            if (is_null($lead->branch_id)) {
                $lead->branch_id = auth()->user()->branch_id ?? 2;
            }
        });

        static::addGlobalScope('per_branch', function (Builder $builder) {
            // $builder->where('branch_id', auth()->user()->branch_id);
        });
    }


    public function scopeFilter(Builder $builder, $filters)
    {
        if (Gate::allows('lead-search-filter')) {
            $builder->when($filters['search'] ?? false, function ($builder, $value) {
                $builder->where('name', 'LIKE', "%$value%")
                    ->orWhere('notes', 'LIKE', "%$value%")
                    ->orWhereHas('phones', fn ($q) => $q->where('number', 'LIKE', "%$value%"));
            });
        }

        if (Gate::allows('lead-branch-filter')) {
            $builder->when($filters['branches_ids'] ?? false, function ($builder, $value) {
                return $builder->whereIn('branch_id', $value);
            });
        }

        if (Gate::allows('lead-event-filter')) {
            $builder->when($filters['events_ids'] ?? false, function ($builder, $value) {
                return $builder->whereIn('event', $value);
            });
        }

        if (Gate::allows('lead-reminder-filter')) {
            $builder->when($filters['reminder'] ?? false, function ($builder, $value) {
                return $builder->where('reminder', $value);
            });
        }

        $builder->when(isset($filters['not_assigned']) && $filters['not_assigned'] == 1 ?? false, function ($builder, $value) {
            $builder->whereNull('assigned_to');
        });

        if (Gate::allows('lead-assign-to-filter')) {

            $builder->when($filters['assigned_to'] ?? false, function ($builder, $value) {
                if ($value == 'me') {
                    return $builder->where('assigned_to', auth()->id());
                }

                if ($value == 'my_team') {
                    return $builder->whereIn('assigned_to', auth()->user()->teamsMembersIDs());
                }

                if ($value == 'me_my_team') {
                    return $builder->whereIn('assigned_to', [auth()->id(), ...auth()->user()->teamsMembersIDs()]);
                }
            });
        }

        if (Gate::allows('lead-assign-to-user-filter')) {
            $builder->when($filters['assigned_to_users'] ?? false, function ($builder, $value) {
                return $builder->whereIn('assigned_to', $value);
            });
        }

        if (Gate::allows('lead-assign-to-team-filter')) {
            $builder->when($filters['assigned_to_team'] ?? false, function ($builder, $value) {

                $userTeamLeader = User::find($value);

                return $builder->whereIn('assigned_to', $userTeamLeader->teamsMembersIDs());
            });
        }

        if (Gate::allows('lead-assign-by-user-filter')) {
            $builder->when($filters['assigned_by_users'] ?? false, function ($builder, $value) {
                return $builder->whereIn('assigned_by', $value);
            });
        }

        if (Gate::allows('lead-source-filter')) {
            $builder->when($filters['sources_ids'] ?? false, function ($builder, $value) {
                return $builder->whereRelation('sources', fn ($q) => $q->whereIn('sources.id', $value));
            });
        }

        if (Gate::allows('lead-interest-filter')) {
            $builder->when($filters['interests_ids'] ?? false, function ($builder, $value) {
                return $builder->whereRelation('interests', fn ($q) => $q->whereIn('interests.id', $value));
            });
        }

        if (Gate::allows('lead-project-filter')) {
            $builder->when($filters['projects_ids'] ?? false, function ($builder, $value) {
                return $builder->whereRelation('projects', fn ($q) => $q->whereIn('projects.id', $value));
            });
        }

        if (Gate::allows('lead-created-by-filter')) {
            $builder->when($filters['creators_ids'] ?? false, function ($builder, $value) {
                return $builder->whereIn('created_by', $value);
            });
        }

        if (Gate::allows('lead-created-by-filter')) {

            $builder->when($filters['created_by'] ?? false, function ($builder, $value) {
                if ($value == 'me') {
                    return $builder->where('created_by', auth()->id());
                }

                if ($value == 'my_team') {
                    return $builder->whereIn('created_by', auth()->user()->teamsMembersIDs());
                }

                if ($value == 'me_my_team') {
                    return $builder->whereIn('created_by', [auth()->id(), ...auth()->user()->teamsMembersIDs()]);
                }
            });
        }

        if (Gate::allows('lead-created-at-filter')) {
            if (isset($filters['from_date']) || isset($filters['to_date'])) {

                $filterDateByCol = "created_at";

                if (isset($filters['assigned_to_users'])) {
                    $filterDateByCol = "assigned_at";
                }

                if (isset($filters['from_date'])) {
                    $builder->whereDate($filterDateByCol, ">=", $filters['from_date']);
                }

                if (isset($filters['to_date'])) {
                    $builder->whereDate($filterDateByCol, "<=", $filters['to_date']);
                }
            }
        }
    }

    /**
     * if current user doesn't have * view-unassigned-lead * permission
     * get only the leads that assigned to auth user, and if he is a team leader in a team,
     * get leads that assigned to every team member
     */
    public function scopePermissionsFilter(Builder $builder)
    {
        $user = auth()->user();

        if ($user->owner == 0) {
            // if i don't have this permission i will view my branch leads only
            if (Gate::denies('view-lead-from-all-branches')) {
                $builder->whereIn('branch_id', $user->branches->pluck('id')->toArray());
            }

            $builder->where(function (Builder $builder) use ($user) {

                // if i don't have this permission i will view my created leads only
                if ($user->hasRole('admin', 'marketing-manager', 'marketing-team-leader', 'marketing') && Gate::denies('view-lead-not-createdby-me')) {
                    $builder->where('created_by', $user->id);
                }

                if ($user->hasRole('marketing-manager', 'marketing-team-leader')) {

                    // if i have this permission i will view leads that created by my team
                    if (Gate::denies('view-lead-not-createdby-me') && Gate::allows('view-team-member-lead')) {
                        $builder->orWhereIn('created_by', $user->teamsMembersIDs());
                    }
                }
            });

            $builder->where(function (Builder $builder) use ($user) {
                // if i don't have this permission i will view leads that assigned to me only
                if ($user->hasRole('sales-manager', 'sales-team-leader', 'senior-sales', 'junior-sales') && Gate::denies('view-unassigned-lead')) {
                    $builder->where('assigned_to', $user->id);
                }

                if ($user->hasRole('sales-manager', 'sales-team-leader')) {

                    // if i have this permission i will view leads that assigned to my team
                    if (Gate::denies('view-unassigned-lead') && Gate::allows('view-team-member-lead')) {
                        $builder->orWhereIn('assigned_to', $user->teamsMembersIDs());
                    }
                }
            });
        }
    }

    public function phones()
    {
        return $this->morphMany(PhoneNumber::class, 'callable')->orderBy('id', 'asc');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by', 'id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }

    public function interests()
    {
        return $this->belongsToMany(Interest::class)->withPivot([
            'interest_name'
        ]);
    }

    public function interestsNames()
    {
        // $names = $this->interests->implode(,);
    }

    public function sources()
    {
        return $this->belongsToMany(Source::class)->withPivot([
            'source_name'
        ]);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot([
            'project_name'
        ]);
    }

    // public function currentEvent()
    // {
    //     return $this->hasOne(Event::class);
    // }

    public function eventCreatedBy()
    {
        return $this->belongsTo(User::class, 'event_created_by', 'id');
    }

    public function histories()
    {
        return $this->hasMany(LeadHistory::class)->latest();
    }

    public function lastHistory()
    {
        return $this->histories()->first();
    }

    public function lastEvent()
    {
        return $this->histories()->where('type', 'event')->first() ?? $this->lastHistory();
    }

    public function duplicates()
    {
        $results = DB::table('phone_numbers')
            ->selectRaw('number, COUNT(number) as count')
            ->where('callable_type', '=', 'App\Models\Lead')
            ->groupByRaw('number HAVING count > 1')
            ->get()->toArray();

        $firstNumber = $this->phones->count() ? $this->phones[0]->number : null;

        // return $firstNumber;
        foreach ($results as $result)
            if ($result->number == $firstNumber) return $result->count;

        return 0;
    }

    public function createdAt()
    {
        return $this->created_at?->diffForHumans() ?? __('Unknown');
    }

    public function assignedAt()
    {
        return $this->assigned_at ? Carbon::parse($this->assigned_at)->diffForHumans()  : __('Unknown');
    }
}
