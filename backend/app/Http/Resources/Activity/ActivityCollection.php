<?php

namespace App\Http\Resources\Activity;

use App\Http\Resources\Activity\ActivityResource;
use App\Http\Resources\PaginatedCollection;

class ActivityCollection extends PaginatedCollection
{
    public $collects { get => ActivityResource::class; }
}
