<?php

namespace App\Repositories;

use App\Repositories\Contracts\RecordRepositoryInterface;

use App\Repositories\Repository;
use App\Models\Record;

class RecordRepository extends Repository implements RecordRepositoryInterface
{
    protected string $modelClass = Record::class;
}
