<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\RepositoryInterface;

interface ClassroomRepositoryInterface extends RepositoryInterface
{
    public function getWithTeacherId( int|string $id );
}
