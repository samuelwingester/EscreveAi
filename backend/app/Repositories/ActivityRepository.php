<?php

namespace App\Repositories;

use App\Repositories\Contracts\ActivityRepositoryInterface;

use App\Repositories\Repository;
use App\Models\Activity;

class ActivityRepository extends Repository implements ActivityRepositoryInterface
{
    protected string $modelClass = Activity::class;
}