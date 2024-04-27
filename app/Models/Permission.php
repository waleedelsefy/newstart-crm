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
 * view-any-user, view-user
 * create-user, store-user
 * edit-user, update-user
 * delete-user, restore-user
 * force-delete-user
 */

class Permission extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['module', 'name', 'display_name', 'description'];

    public $translatable = ['display_name'];

    public function roles()
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

    public static function permissionsByModule()
    {
        $permissions = [];
        static::all()->each(function ($permission) use (&$permissions) {
            $permissions[$permission->module][] = $permission;
        });
        return $permissions;
    }
}
