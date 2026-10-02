<?php

namespace App\Http\Resources\Classroom;

use App\Http\Resources\Classroom\ClassroomResource;
use App\Http\Resources\PaginatedResourceCollection;

class ClassroomCollection extends PaginatedResourceCollection
{
    public $collects = ClassroomResource::class;
}
