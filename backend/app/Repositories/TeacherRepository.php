<?php

namespace App\Repositories;

use App\Repositories\Contracts\TeacherRepositoryInterface;

use App\Repositories\Repository;
use App\Models\User;

class TeacherRepository extends Repository implements TeacherRepositoryInterface
{
    protected string $modelClass = User::class;
}