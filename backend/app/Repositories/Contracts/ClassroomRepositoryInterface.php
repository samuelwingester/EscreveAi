<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Query\Contracts\QueryOptionsInterface;

interface ClassroomRepositoryInterface extends RepositoryInterface
{
    public function getByTeacher( int|string $id, array $filters = [], array $columns = ["*"], ?QueryOptionsInterface $options = null );

    public function getByTeacherWithStudents( int|string $id );

    public function getStats( int|string $id );
}
