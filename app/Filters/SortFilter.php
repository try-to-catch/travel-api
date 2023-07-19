<?php

namespace App\Filters;

use App\Contracts\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SortFilter implements Filter
{
    public function apply(Builder $query, Request $request): Builder
    {
        return $query
            ->when(
                $request->sortBy,
                fn($query) => $query->orderBy($request->sortBy, $request->sortOrder ?? 'asc')
            );
    }
}
