<?php

namespace App\Repositories;

use App\Repositories\Contracts\StudentRepositoryInterface;

use App\Repositories\Repository;

use App\Models\Student;

class StudentRepository extends Repository implements StudentRepositoryInterface
{
    protected string $modelClass = Student::class;

    function getByClassroom(int|string $id)
    {
        return $this->getWhere( [ 'classroom_id' => $id ], [ 'id', 'name', 'writing_level' ] );
    }
}
