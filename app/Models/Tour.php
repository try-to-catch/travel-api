<?php

namespace App\Models;

use App\Http\Requests\TourListRequest;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;
    use HasUuids;

    public const PER_PAGE = 15;
    protected $fillable = [
        'travel_id',
        'name',
        'starting_date',
        'ending_date',
        'price',
    ];

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    public function scopePriceFilter($query, TourListRequest $request)
    {
        return $query
            ->when(
                $request->priceFrom,
                fn ($query) => $query->where('price', '>=', $request->priceFrom * 100)
            )
            ->when(
                $request->priceTo,
                fn ($query) => $query->where('price', '<=', $request->priceTo * 100)
            );
    }

    public function scopeDateFilter($query, TourListRequest $request)
    {
        return $query
            ->when(
                $request->dateFrom,
                fn ($query) => $query->where('starting_date', '>=', $request->dateFrom)
            )
            ->when(
                $request->dateTo,
                fn ($query) => $query->where('starting_date', '<=', $request->dateTo)
            );
    }

    public function scopeSort($query, TourListRequest $request)
    {
        return $query
            ->when(
                $request->sortBy,
                fn ($query) => $query->orderBy($request->sortBy, $request->sortOrder ?? 'asc')
            );
    }
}
