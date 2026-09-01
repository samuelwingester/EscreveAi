<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\RepositoryInterface;

interface ClassroomRepositoryInterface extends RepositoryInterface
{
    public function getByTeacher(
        int|string $id, array $filters = [], array $columns = ["*"],
        string $orderBy = "id", int $limit = 0, int $offset = 0
    );

    public function getByTeacherWithStudents( int|string $id );

    public function getStats( int|string $id );
}
