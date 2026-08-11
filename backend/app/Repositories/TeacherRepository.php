<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\User;

// NOTA: Futuramente criar uma interface para implementar nessa classe
class TeacherRepository extends Repository
{
    protected string $modelClass = User::class;
}