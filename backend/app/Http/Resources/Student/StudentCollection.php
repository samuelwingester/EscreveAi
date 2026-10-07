<?php

namespace App\Http\Resources\Student;

use App\Http\Resources\PaginatedCollection;
use App\Http\Resources\Student\StudentResource;

class StudentCollection extends PaginatedCollection
{
    public $collects { get => StudentResource::class; }
}
