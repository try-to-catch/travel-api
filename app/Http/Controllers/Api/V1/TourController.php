<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourListRequest;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TourController extends Controller
{
    public function index(Travel $travel, TourListRequest $request): AnonymousResourceCollection
    {
        $tours = $travel->tours()
            ->priceFilter()
            ->dateFilter()
            ->sort()
            ->latest('starting_date')
            ->paginate(Tour::PER_PAGE);

        return TourResource::collection($tours);
    }
}
