<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\RepositoryInterface;

interface ClassroomRepositoryInterface extends RepositoryInterface
{
    public function getByTeacher( int|string $id );

    public function getStats( int|string $id );
}
