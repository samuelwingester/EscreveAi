<?php

namespace App\Services\Student;

use App\Repositories\Contracts\StudentRepositoryInterface;

class DataStudentService
{
	public function __construct(
		protected StudentRepositoryInterface $repository
	) {}

    public function getByClassroom( int|string $id ) {
        return $this->repository->getByClassroom( $id );
    }
}
