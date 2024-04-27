<?php

namespace App\Models;

use App\Traits\Dashboard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory, HasTranslations, Dashboard;

    protected $fillable = ['name', 'slug', 'description', 'developer_id'];
    public $translatable = ['name'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function booted(): void
    {
        static::saving(function (Project $project) {
            $project->slug = Str::slug($project->getTranslation('name', 'en'));
        });
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['search'] ?? false, function ($builder, $value) {
            return $builder->where('name', "%$value%")
                ->orWhere('name->en', 'LIKE', "%$value%")
                ->orWhere('name->ar', 'LIKE', "%$value%")
                ->orWhere('description', 'LIKE', "%$value%");
        });

        $builder->when($filters['developer_id'] ?? false, function ($builder, $value) {
            return $builder->where('developer_id', $value);
        });
    }

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }

    public function leads()
    {
        return $this->belongsToMany(Lead::class);
    }
}
