<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;

trait HasRolesPermissions
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasRole(...$roles)
    {
        if ($this->owner) return true;
        return $this->roles->contains(function ($role, $key) use ($roles) {
            return in_array($role->name, $roles);
        });
    }

    public function hasPermissions($permissions, $allTrue = false)
    {
        if ($this->owner) return true;

        $permissionsCount = count($permissions);
        $result = [];

        $this->permissions->contains(function ($permission, $key) use ($permissions, &$result) {
            if (in_array($permission->name, $permissions))
                $result[$permission->name] = 1;
        });

        if ($permissionsCount != count($result)) {
            $this->roles->contains(function ($role, $key) use ($permissions, &$result) {
                foreach ($role->permissions as $role_permission) {
                    if (in_array($role_permission->name, $permissions))
                        $result[$role_permission->name] = 1;
                }
            });
        }

        if ($allTrue)
            return $permissionsCount == count($result);

        return count($result) > 0;
    }

    public function scopeWhereHasPermission(Builder $builder, $permissionName)
    {
        $builder->whereHas('permissions', function ($q) use ($permissionName) {
            if (is_array($permissionName)) {
                $q->whereIn('name', $permissionName);
            } else {
                $q->where('name', $permissionName);
            }
        })->orWhereHas('roles', function ($q) use ($permissionName) {
            $q->whereHas('permissions', function ($q) use ($permissionName) {
                if (is_array($permissionName)) {
                    $q->whereIn('name', $permissionName);
                } else {
                    $q->where('name', $permissionName);
                }
            });
        });
    }

    public function scopeWhereHasRole(Builder $builder, $roleName)
    {
        $builder->whereHas('roles', function ($builder) use ($roleName) {
            if (is_array($roleName)) {
                $builder->whereIn('name', $roleName);
            } else {
                $builder->where('name', $roleName);
            }
        });
    }
}
