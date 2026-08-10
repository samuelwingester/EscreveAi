<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Classroom;

// NOTA: Futuramente criar uma interface para implementar nessa classe
class ClassroomRepository extends Repository
{
    protected string $modelClass = Classroom::class;
}