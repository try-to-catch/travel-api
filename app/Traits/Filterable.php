<?php

namespace App\Traits;

use App\Filters\DateFilter;
use App\Filters\PriceFilter;
use App\Filters\SortFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Filterable
{
    //array with filters alias and their classes
    protected array $filters = [
        'sort' => SortFilter::class,
        'date' => DateFilter::class,
        'price' => PriceFilter::class,
    ];

    public function scopeFilter(Builder $query, Request $request, array $filters): Builder
    {
        foreach ($filters as $filter) {
            if (array_key_exists($filter, $this->filters)) {
                $filterInstance = new $this->filters[$filter];
                $query = $filterInstance->apply($query, $request);
            }
        }
        return $query;

    }

}
