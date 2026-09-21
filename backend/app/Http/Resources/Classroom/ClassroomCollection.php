<?php

namespace App\Http\Resources\Classroom;

use App\Http\Resources\Classroom\ClassroomResource;
use App\Http\Resources\PaginatedCollection;

class ClassroomCollection extends PaginatedCollection
{
    public $collects { get => ClassroomResource::class; }
}
