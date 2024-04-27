<?php

namespace App\Models;

use App\Traits\Dashboard;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class Team extends Model
{
    use HasFactory, Dashboard;

    protected $fillable = ['name', 'description', 'user_id', 'created_by'];
    protected $table = 'teams';

    public function leader()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function type()
    {
        if ($this->leader->roles->count() && $this->leader->roles[0]->name == 'sales-team-leader')
            return __('Sales Members');

        if ($this->leader->roles->count() && $this->leader->roles[0]->name == 'sales-manager')
            return __('Sales Leaders Members');

        if ($this->leader->roles->count() && $this->leader->roles[0]->name == 'marketing-team-leader')
            return __('Marketing Members');

        if ($this->leader->roles->count() && $this->leader->roles[0]->name == 'marketing-manager')
            return __('Marketing Leaders Members');

        return __('Unknown');
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['search'] ?? false, function ($builder, $value) {
            return $builder->where('name', 'LIKE', "%$value%")->orWhere('description', 'LIKE', "%$value%");
        });

        $builder->when($filters['team_role'] ?? false, function ($builder, $value) {

            if ($value == 'leader') {
                return $builder->where('user_id', auth()->id());
            }

            if ($value == 'member') {
                return $builder->whereHas('members', function ($q) {
                    $q->where('users.id', auth()->id());
                });
            }
        });

        $builder->when($filters['leader'] ?? false, function ($builder, $value) {
            return $builder->where('user_id', $value);
        });
    }

    public function members()
    {
        return $this->belongsToMany(User::class);
    }

    public function scopePermissionsFilter(Builder $builder)
    {
        $user = auth()->user();

        $builder->where(function (Builder $builder) use ($user) {
            if (Gate::denies('view-team-not-createdby-me')) {
                $builder->where('created_by', $user->id);
            }

            if (Gate::denies('view-team-not-leadby-me')) {
                $builder->orWhere('user_id', $user->id);
            }

            if (Gate::denies('view-team-not-member-in')) {
                $builder->orWhereHas('members', function (Builder $builder) use ($user) {
                    $builder->where('users.id', $user->id);
                });
            }
        });
    }
}
