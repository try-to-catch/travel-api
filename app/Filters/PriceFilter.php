<?php

namespace App\Filters;

use App\Contracts\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PriceFilter implements Filter
{
    public function apply(Builder $query, Request $request): Builder
    {
        return $query
            ->when(
                $request->priceFrom,
                fn($query) => $query->where('price', '>=', $request->priceFrom * 100)
            )
            ->when(
                $request->priceTo,
                fn($query) => $query->where('price', '<=', $request->priceTo * 100)
            );
    }

}
