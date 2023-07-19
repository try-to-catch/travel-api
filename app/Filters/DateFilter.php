<?php

namespace App\Filters;

use App\Contracts\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DateFilter implements Filter
{
    public function apply(Builder $query, Request $request): Builder
    {
        return $query
            ->when(
                $request->dateFrom,
                fn($query) => $query->where('starting_date', '>=', $request->dateFrom)
            )
            ->when(
                $request->dateTo,
                fn($query) => $query->where('starting_date', '<=', $request->dateTo)
            );
    }
}
