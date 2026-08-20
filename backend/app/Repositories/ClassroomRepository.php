<?php

namespace App\Repositories;

use App\Repositories\Contracts\ClassroomRepositoryInterface;

use App\Repositories\Repository;
use App\Models\Classroom;

class ClassroomRepository extends Repository implements ClassroomRepositoryInterface
{
    protected string $modelClass = Classroom::class;
}