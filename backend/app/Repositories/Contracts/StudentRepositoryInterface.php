<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\RepositoryInterface;

interface StudentRepositoryInterface extends RepositoryInterface
{
    function getByClassroom( int|string $id );
}
