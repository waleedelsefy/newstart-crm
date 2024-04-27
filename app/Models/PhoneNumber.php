<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    protected $fillable  = ['callable_type', 'callable_id', 'country_code', 'number'];


    protected static function booted()
    {
    }

    public function phoneWithoutPlus()
    {
        return str_replace('+', '', $this->number);
    }

    public function callable()
    {
        return $this->morphTo();
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['search'] ?? false, function ($builder, $value) {
            return $builder->where('number', 'LIKE', "%$value%");
        });
    }
}
