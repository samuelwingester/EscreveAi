<?php

namespace App\Repositories;

use App\Repositories\Contracts\TeacherRepositoryInterface;

use App\Repositories\Repository;
use App\Models\Record;

class RecordRepository extends Repository implements TeacherRepositoryInterface
{
    protected string $modelClass = Record::class;
}