<?php

namespace App\Models;

use App\Traits\Dashboard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory, Dashboard;

    protected $fillable = ['name', 'description', 'with_date', 'with_notes'];

    protected static function boot()
    {
        parent::boot();

        static::created(function (Event $event) {
            // Create Permission for event in dashboard module

            $permissionName = "view-event-{{ $event->name }}-dashboard";
            $permissionDisplayName = [
                'en' => Str::slug($permissionName),
                'ar' => Str::slug($permissionName),
            ];

            Permission::create(
                [
                    'module' => 'dashboard',
                    'name' => $permissionName,
                    'display_name' => $permissionDisplayName,
                ]
            );
        });

        static::updated(function (Event $event) {
            $oldPermissionName = "view-event-" . $event->getOriginal('name') . "-dashboard";
            $newPermissionName = "view-event-" . $event->name . "-dashboard";

            $permissionDisplayName = [
                'en' => Str::slug($newPermissionName),
                'ar' => Str::slug($newPermissionName),
            ];

            $permission = Permission::where('module', 'dashboard')
                ->where(function ($q) use ($oldPermissionName, $newPermissionName) {
                    $q->where('name', $oldPermissionName)
                        ->orWhere('name', $newPermissionName);
                })->first();

            if ($permission) {
                $permission->module = 'dashboard';
                $permission->name = $newPermissionName;
                $permission->display_name = $permissionDisplayName;
                $permission->save();
            }
        });
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['search'] ?? false, function ($builder, $value) {
            return $builder->where('name', "%$value%")->orWhere('description', 'LIKE', "%$value%");
        });

        $builder->when($filters['with_date'] ?? false, function ($builder, $value) {
            return $builder->where('with_date', $value);
        });

        $builder->when($filters['with_notes'] ?? false, function ($builder, $value) {
            return $builder->where('with_notes', $value);
        });
    }
}
