<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\Dashboard;
use App\Traits\HasRolesPermissions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, HasRolesPermissions, Dashboard;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'country_code',
        'phone_number',
        'owner',
        'active',
        'branch_id',
        'photo',
        'last_seen_date',
        'gender',
        'created_by'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public static function booted(): void
    {
        static::creating(function (User $user) {
            $user->created_by = auth()->id();
            $user->username = Str::slug($user->name);
        });

        static::updating(function (User $user) {
            $user->username = Str::slug($user->name);
        });
    }

    /**
     * Get the entity's notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->latest();
    }

    public function jobTitle()
    {
        if ($this->owner)
            return __('Owner');

        if ($this->roles->count())
            return $this->roles[0]->display_name;

        return __('Unknown');
    }

    public function scopeOwners(Builder $builder)
    {
        $builder->where('owner', 1);
    }

    public function scopeNotOwners(Builder $builder)
    {
        $builder->where('owner', '!=', 1);
    }

    public function scopeAdmins(Builder $builder)
    {
        $builder->notOwners()->whereHasRole('admin');
    }

    public function scopeMarketing(Builder $builder)
    {
        $builder->whereHasRole('marketing');
    }

    public function scopeMarketingManagers(Builder $builder)
    {
        $builder->whereHasRole('marketing-manager');
    }

    public function scopeMarketingTeamLeaders(Builder $builder)
    {
        $builder->whereHasRole('marketing-team-leader');
    }

    public function scopeEveryMarketing(Builder $builder)
    {
        $builder->whereHasRole(['marketing-manager', 'marketing-team-leader', 'marketing']);
    }

    public function scopeEveryMarketingLeader(Builder $builder)
    {
        $builder->whereHasRole(['marketing-manager', 'marketing-team-leader']);
    }

    public function scopeSalesManagers(Builder $builder)
    {
        $builder->whereHasRole('sales-manager');
    }

    public function scopeSalesTeamLeaders(Builder $builder)
    {
        $builder->whereHasRole('sales-team-leader');
    }

    public function scopeSales(Builder $builder)
    {
        $builder->whereHasRole(['junior-sales', 'senior-sales']);
    }

    public function scopeSeniorSales(Builder $builder)
    {
        $builder->whereHasRole('senior-sales');
    }

    public function scopeJuniorSales(Builder $builder)
    {
        $builder->whereHasRole('junior-sales');
    }

    public function scopeEverySales(Builder $builder)
    {
        $builder->whereHasRole(['sales-manager', 'sales-team-leader', 'junior-sales', 'senior-sales']);
    }

    public function scopeEverySalesLeader(Builder $builder)
    {
        $builder->whereHasRole(['sales-manager', 'sales-team-leader']);
    }

    public function scopeAvailableToAssign(Builder $builder)
    {
        $builder->whereHasPermission('available-for-assign-leads-to-him');
    }

    public function scopeCanCreateLeads(Builder $builder)
    {
        $builder->whereHasPermission('create-lead');
    }

    public function scopeCanAssignLeadsToEmployees(Builder $builder)
    {
        $builder->whereHasPermission('assign-lead-to-employee');
    }

    public function leadsYouCreated()
    {
        $filters = request()->query();

        // Date and time filters
        $from_date = $filters['from_date'] ?? false ? Carbon::parse($filters['from_date'])->format('Y-m-d') : null;
        $to_date = $filters['to_date'] ?? false ? Carbon::parse($filters['to_date'])->format('Y-m-d') : null;
        $from_time = $filters['from_time'] ?? false ? Carbon::parse($filters['from_time'])->format('H:i:s') : null;
        $to_time = $filters['to_time'] ?? false ? Carbon::parse($filters['to_time'])->format('H:i:s') : null;

        $leads = $this->hasMany(Lead::class, 'created_by', 'id');

        if ($from_date)
            $leads->whereDate("created_at", ">=", $from_date);
        if ($to_date)
            $leads->whereDate("created_at", "<=", $to_date);
        if ($from_time)
            $leads->whereTime("created_at", ">=", $from_time);
        if ($to_time)
            $leads->whereTime("created_at", "<=", $to_time);

        return $leads;
    }

    public function leadsYouCreatedHistory()
    {
        $filters = request()->query();

        // Date and time filters
        $from_date = $filters['from_date'] ?? false ? Carbon::parse($filters['from_date'])->format('Y-m-d') : null;
        $to_date = $filters['to_date'] ?? false ? Carbon::parse($filters['to_date'])->format('Y-m-d') : null;
        $from_time = $filters['from_time'] ?? false ? Carbon::parse($filters['from_time'])->format('H:i:s') : null;
        $to_time = $filters['to_time'] ?? false ? Carbon::parse($filters['to_time'])->format('H:i:s') : null;

        $youCreated = $this->hasMany(LeadHistory::class, 'user_id', 'id')->where('type', 'created');

        if ($from_date)
            $youCreated->whereDate("created_at", ">=", $from_date);
        if ($to_date)
            $youCreated->whereDate("created_at", "<=", $to_date);
        if ($from_time)
            $youCreated->whereTime("created_at", ">=", $from_time);
        if ($to_time)
            $youCreated->whereTime("created_at", "<=", $to_time);

        return $youCreated;
    }

    public function leadsAssignedByYou()
    {
        return $this->hasMany(Lead::class, 'assigned_by', 'id');
    }

    public function leadsAssignedToYou()
    {
        return $this->hasMany(Lead::class, 'assigned_to', 'id');
    }

    public function leadsAssignedToYouHistory()
    {
        $filters = request()->query();

        // Date and time filters
        $from_date = $filters['from_date'] ?? false ? Carbon::parse($filters['from_date'])->format('Y-m-d') : null;
        $to_date = $filters['to_date'] ?? false ? Carbon::parse($filters['to_date'])->format('Y-m-d') : null;
        $from_time = $filters['from_time'] ?? false ? Carbon::parse($filters['from_time'])->format('H:i:s') : null;
        $to_time = $filters['to_time'] ?? false ? Carbon::parse($filters['to_time'])->format('H:i:s') : null;

        $assigendToYou =  $this->hasMany(LeadHistory::class, 'assigned_to', 'id')->where('type', 'assigned');

        if ($from_date)
            $assigendToYou->whereDate("created_at", ">=", $from_date);
        if ($to_date)
            $assigendToYou->whereDate("created_at", "<=", $to_date);
        if ($from_time)
            $assigendToYou->whereTime("created_at", ">=", $from_time);
        if ($to_time)
            $assigendToYou->whereTime("created_at", "<=", $to_time);

        return $assigendToYou;
    }

    public function teamsICreated()
    {
        return $this->hasMany(Team::class, 'created_by', 'id');
    }

    public function teamsILead()
    {
        return $this->hasMany(Team::class, 'user_id', 'id');
    }

    public function teamsIMember()
    {
        return $this->belongsToMany(Team::class);
    }

    public function teamsMembersIDs()
    {
        $teamsMembersIds = [];

        // iterate in the user teams that he is a team leader in it
        foreach ($this->teamsILead as $team) {
            // iterate in every team's members and get member ID
            foreach ($team->members as $member) {
                // Check first if the member has leads assigned to him
                // if ($member->leadsAssignedToYou->count() > 0)
                $teamsMembersIds[] = $member->id;

                /**
                 * If the user is a sales manager that means team members have a sales team leader Role,
                 * so we will get the IDs of members that are in sales team leader teams.
                 * 
                 * If the user is a marketing manager that means team members have a marketing team leader Role,
                 * so we will get the IDs of members that are in marketing team leader teams.
                 */
                if ($member->hasRole('sales-team-leader', 'marketing-team-leader')) {
                    // iterate in the sales team leader teams that he is a team leader in it
                    foreach ($member->teamsILead as $teamLeaderTeam) {
                        // iterate in every team's members and get member ID
                        foreach ($teamLeaderTeam->members as $teamMember) {
                            // Check first if the member has leads assigned to him
                            // if ($teamMember->leadsAssignedToYou->count() > 0)
                            $teamsMembersIds[] = $teamMember->id;
                        }
                    }
                }
            }
        }

        return $teamsMembersIds;
    }

    public function canViewAllLeadHistory()
    {
        return $this->hasPermissions(['view-lead-history-all']);
    }

    public function events()
    {
        $filters = request()->query();

        // Date and time filters
        $from_date = $filters['from_date'] ?? false ? Carbon::parse($filters['from_date'])->format('Y-m-d') : null;
        $to_date = $filters['to_date'] ?? false ? Carbon::parse($filters['to_date'])->format('Y-m-d') : null;
        $from_time = $filters['from_time'] ?? false ? Carbon::parse($filters['from_time'])->format('H:i:s') : null;
        $to_time = $filters['to_time'] ?? false ? Carbon::parse($filters['to_time'])->format('H:i:s') : null;

        $events = $this->hasMany(LeadHistory::class, 'user_id', 'id')
            ->where('type', 'event')
            ->where('assigned_to', $this->id)
            ->whereNot('event_name', 'no-action');

        if ($from_date)
            $events->whereDate("created_at", ">=", $from_date);
        if ($to_date)
            $events->whereDate("created_at", "<=", $to_date);
        if ($from_time)
            $events->whereTime("created_at", ">=", $from_time);
        if ($to_time)
            $events->whereTime("created_at", "<=", $to_time);

        return $events;
    }

    public function myCreatedLeadsEvents()
    {
        $filters = request()->query();

        // Date and time filters
        $from_date = $filters['from_date'] ?? false ? Carbon::parse($filters['from_date'])->format('Y-m-d') : null;
        $to_date = $filters['to_date'] ?? false ? Carbon::parse($filters['to_date'])->format('Y-m-d') : null;
        $from_time = $filters['from_time'] ?? false ? Carbon::parse($filters['from_time'])->format('H:i:s') : null;
        $to_time = $filters['to_time'] ?? false ? Carbon::parse($filters['to_time'])->format('H:i:s') : null;

        $events = LeadHistory::where('type', 'event')->whereHas('lead', function ($q) {
            $q->where('created_by', $this->id);
        })->whereNot('event_name', 'no-action');

        if ($from_date)
            $events->whereDate("created_at", ">=", $from_date);
        if ($to_date)
            $events->whereDate("created_at", "<=", $to_date);
        if ($from_time)
            $events->whereTime("created_at", ">=", $from_time);
        if ($to_time)
            $events->whereTime("created_at", "<=", $to_time);

        return $events;
    }

    public function eventsOnMyTeamsMembersLeads()
    {
        $filters = request()->query();

        // Date and time filters
        $from_date = $filters['from_date'] ?? false ? Carbon::parse($filters['from_date'])->format('Y-m-d') : null;
        $to_date = $filters['to_date'] ?? false ? Carbon::parse($filters['to_date'])->format('Y-m-d') : null;
        $from_time = $filters['from_time'] ?? false ? Carbon::parse($filters['from_time'])->format('H:i:s') : null;
        $to_time = $filters['to_time'] ?? false ? Carbon::parse($filters['to_time'])->format('H:i:s') : null;

        $events =  $this->hasMany(LeadHistory::class, 'user_id', 'id')
            ->where('type', 'event')
            ->whereIn('assigned_to', $this->teamsMembersIDs())
            ->whereNot('event_name', 'no-action');

        if ($from_date)
            $events->whereDate("created_at", ">=", $from_date);
        if ($to_date)
            $events->whereDate("created_at", "<=", $to_date);
        if ($from_time)
            $events->whereTime("created_at", ">=", $from_time);
        if ($to_time)
            $events->whereTime("created_at", "<=", $to_time);

        return $events;
    }

    public function eventsOnMyTeamsMembersCreatedLeads()
    {
        $filters = request()->query();

        // Date and time filters
        $from_date = $filters['from_date'] ?? false ? Carbon::parse($filters['from_date'])->format('Y-m-d') : null;
        $to_date = $filters['to_date'] ?? false ? Carbon::parse($filters['to_date'])->format('Y-m-d') : null;
        $from_time = $filters['from_time'] ?? false ? Carbon::parse($filters['from_time'])->format('H:i:s') : null;
        $to_time = $filters['to_time'] ?? false ? Carbon::parse($filters['to_time'])->format('H:i:s') : null;

        $events = LeadHistory::where('type', 'event')
            ->whereHas('lead', function ($q) {
                $q->whereIn('created_by', $this->teamsMembersIDs());
            })->whereNot('event_name', 'no-action');

        if ($from_date)
            $events->whereDate("created_at", ">=", $from_date);
        if ($to_date)
            $events->whereDate("created_at", "<=", $to_date);
        if ($from_time)
            $events->whereTime("created_at", ">=", $from_time);
        if ($to_time)
            $events->whereTime("created_at", "<=", $to_time);

        return $events;
    }


    public function eventsReport()
    {
        return $this->events()->select('event_name', DB::raw('COUNT(*) AS count'))->groupBy('event_name')->get() ?? [];
    }

    public function myCreatedLeadsEventsReport()
    {
        return $this->myCreatedLeadsEvents()->select('event_name', DB::raw('COUNT(*) AS count'))->groupBy('event_name')->get() ?? [];
    }

    public function eventsOnMyTeamsMembersLeadsReport()
    {
        return $this->eventsOnMyTeamsMembersLeads()->select('event_name', DB::raw('COUNT(*) AS count'))->groupBy('event_name')->get() ?? [];
    }

    public function eventsOnMyTeamsMembersCreatedLeadsReport()
    {
        return $this->eventsOnMyTeamsMembersCreatedLeads()->select('event_name', DB::raw('COUNT(*) AS count'))->groupBy('event_name')->get() ?? [];
    }

    public function teamsILeadMembers()
    {
        return User::whereIn('id', $this->teamsMembersIDs())->get();
    }

    /**
     * My leads events and the events that i made on my teams' members' leads
     */
    public function allEventsCount()
    {
        return $this->events->count() + $this->eventsOnMyTeamsMembersLeads->count();
    }

    public function leadsAssignedToYouAndYourTeamsMembers()
    {
        $filters = request()->query();

        // Date and time filters
        $from_date = $filters['from_date'] ?? false ? Carbon::parse($filters['from_date'])->format('Y-m-d') : null;
        $to_date = $filters['to_date'] ?? false ? Carbon::parse($filters['to_date'])->format('Y-m-d') : null;
        $from_time = $filters['from_time'] ?? false ? Carbon::parse($filters['from_time'])->format('H:i:s') : null;
        $to_time = $filters['to_time'] ?? false ? Carbon::parse($filters['to_time'])->format('H:i:s') : null;

        $leads = Lead::whereIn('assigned_to', [$this->id, ...$this->teamsMembersIDs()]);

        if ($from_date)
            $leads->whereDate("created_at", ">=", $from_date);
        if ($to_date)
            $leads->whereDate("created_at", "<=", $to_date);
        if ($from_time)
            $leads->whereTime("created_at", ">=", $from_time);
        if ($to_time)
            $leads->whereTime("created_at", "<=", $to_time);


        return $leads->get();
    }

    public function allEventsOnMyCreatedLeadsCount()
    {
        return $this->myCreatedLeadsEvents()->count() + $this->eventsOnMyTeamsMembersCreatedLeads()->count();
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'username';
    }

    protected function lastSeenAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value != null ?  Carbon::parse($value)->diffForHumans(null, true) : 'offline',
            set: fn ($value) => $this->last_seen_at = $value
        );
    }

    public function phoneWithoutCode()
    {
        return str_replace($this->country_code, '', $this->phone_number);
    }

    public function getPhoto()
    {
        if (!$this->photo) {
            if ($this->gender)
                return asset("images/default/default_{$this->gender}.jpg");
            return asset('images/default/default.jpg');
        }

        if ($this->photo && Str::startsWith($this->photo, 'http'))
            return $this->photo;

        return asset("storage/{$this->photo}");
    }

    public function deleteOldPhoto()
    {
        if ($this->photo && Storage::has($this->photo)) {
            Storage::delete($this->photo);
        }
    }

    // Active branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // All branches
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_user', 'user_id', 'branch_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->withDefault([
            'name' => __('Unknown'),
        ]);
    }

    protected function phoneNumber(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($phone) =>  $this->phone_number = request()->country_code . $phone
        );
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['gender'] ?? false, function ($builder, $value) {
            return $builder->where('gender', $value);
        });

        $builder->when($filters['branch_id'] ?? false, function ($builder, $value) {
            return $builder->where('branch_id', $value);
        });

        $builder->when($filters['role_id'] ?? false, function ($builder, $value) {

            if ($value == 'owner') {
                return $builder->owners();
            }

            return $builder->whereRelation('roles', 'roles.id',  $value);
        });

        $builder->when($filters['permission_id'] ?? false, function ($builder, $value) {
            return $builder->where(function ($builder) use ($value) {
                $builder->whereRelation('permissions', 'permissions.id',  $value)
                    ->orWhere(function ($builder) use ($value) {
                        $builder->whereHas('roles', function ($builder) use ($value) {
                            $builder->whereRelation('permissions', 'permissions.id',  $value);
                        });
                    });
            });
        });

        $builder->when($filters['search'] ?? false, function ($builder, $value) {
            return $builder->where('name', 'LIKE', "%$value%")
                ->orWhere('username', 'LIKE', "%$value%")
                ->orWhere('email', 'LIKE', "%$value%")
                ->orWhere('phone_number', 'LIKE', "%$value%");
        });
    }

    public function scopePermissionsFilter(Builder $builder)
    {
        $user = auth()->user();

        if (Gate::denies('view-user-from-all-branches')) {
            $builder->whereHas('branches', function ($builder) use ($user) {
                $builder->whereIn('branch_id', $user->branches->pluck('id')->toArray());
            });
        }

        if (Gate::denies('view-user-not-createdby-me')) {
            $builder->where('created_by', $user->id);
        }
    }

    public function createdAt()
    {
        return $this->created_at?->diffForHumans() ?? __('Unknown');
    }

    public function lastSeenDate()
    {
        if (!$this->last_seen_date)
            return __('Unknown');
        return Carbon::parse($this->last_seen_date)->diffForHumans();
    }
}
