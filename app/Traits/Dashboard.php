<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait Dashboard
{
    public function scopeDashboardFilter(Builder $builder, $filters)
    {
        // Date and time filters
        $from_date = $filters['from_date'] ?? false ? Carbon::parse($filters['from_date'])->format('Y-m-d') : null;
        $to_date = $filters['to_date'] ?? false ? Carbon::parse($filters['to_date'])->format('Y-m-d') : null;
        $from_time = $filters['from_time'] ?? false ? Carbon::parse($filters['from_time'])->format('H:i:s') : null;
        $to_time = $filters['to_time'] ?? false ? Carbon::parse($filters['to_time'])->format('H:i:s') : null;

        // if there's join statement tablename.created_at
        $tableName = $this->table ? "{$this->table}." : '';

        if ($from_date)
            $builder->whereDate("{$tableName}created_at", ">=", $from_date);
        if ($to_date)
            $builder->whereDate("{$tableName}created_at", "<=", $to_date);
        if ($from_time)
            $builder->whereTime("{$tableName}created_at", ">=", $from_time);
        if ($to_time)
            $builder->whereTime("{$tableName}created_at", "<=", $to_time);
    }
}
