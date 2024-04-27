<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Traits\Dashboard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Branch extends Model
{
    use HasFactory, HasTranslations, Dashboard;

    protected $fillable = ['name', 'slug', 'address', 'description', 'status'];

    public $translatable = ['name'];

    public const AVAILABLE_STATUS = ['open', 'temporarily-closed', 'closed'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'branch_user',   'branch_id', 'user_id');
    }

    public function scopeOpen(Builder $builder)
    {
        return $builder->where('status', 'open');
    }

    public function scopeClosed(Builder $builder)
    {
        return $builder->where('status', 'closed');
    }

    public function scopeTmpClosed(Builder $builder)
    {
        return $builder->where('status', 'temporarily-closed');
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['status'] ?? false, function ($builder, $value) {
            return $builder->where('status', $value);
        });

        $builder->when($filters['search'] ?? false, function ($builder, $value) {
            return $builder->where('name->en', 'LIKE', "%$value%")->orWhere('name->ar', 'LIKE', "%$value%");
        });
    }

    public static function getAvailableStatus()
    {
        $availableStatus = [];

        foreach (Branch::AVAILABLE_STATUS as $status) {
            $availableStatus[$status] = Helper::convertToNormalWords($status);
        }
        return $availableStatus;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected function status(): Attribute
    {

        return Attribute::make(get: fn ($val) => __(Helper::convertToNormalWords($val ?? '')));
    }
}
