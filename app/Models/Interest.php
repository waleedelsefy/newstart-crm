<?php

namespace App\Models;

use App\Traits\Dashboard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Interest extends Model
{
    use HasFactory, HasTranslations, Dashboard;

    protected $fillable = ['name', 'slug', 'description'];
    public $translatable = ['name'];

    public static function booted(): void
    {
        static::saving(function (Interest $interest) {
            $interest->slug = Str::slug($interest->getTranslation('name', 'en'));
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
    }

    public function leads()
    {
        return $this->belongsToMany(Lead::class);
    }
}
