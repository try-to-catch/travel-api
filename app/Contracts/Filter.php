<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

interface Filter
{
    public function apply(Builder $query, Request $request): Builder;
}
