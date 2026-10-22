<?php

namespace App\Services\Classroom;

use App\Repositories\ClassroomRepository;

class GenerateStatsService
{
    public function __construct(
        protected ClassroomRepository $repository
    ) {}

    public function generate( int|string $classId ) : array
    {
        return $this->repository->getStats( $classId );
    }
}
