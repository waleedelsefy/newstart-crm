<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

/**
 * Example:-
 * user, admin, super-admin
 */

class Role extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['name', 'display_name', 'description'];

    public $translatable = ['display_name'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['search'] ?? false, function ($builder, $value) {
            return $builder->where('name', "%$value%")
                ->orWhere('display_name->en', 'LIKE', "%$value%")
                ->orWhere('display_name->ar', 'LIKE', "%$value%")
                ->orWhere('description', 'LIKE', "%$value%");
        });
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    protected function name(): Attribute
    {
        return Attribute::make(set: fn ($val) => Str::slug($val));
    }
}
