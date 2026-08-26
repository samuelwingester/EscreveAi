<?php

namespace App\Services\Classroom;

use App\Models\Classroom;
use App\Repositories\Contracts\ClassroomRepositoryInterface;

use App\Models\User;

class DataClassroomService
{
	public function __construct(
		protected ClassroomRepositoryInterface $repository
	) {}

	public function list( User $teacher )
	{
		return $this->repository->getWithTeacherId( $teacher->id );
	}

    public function generateStats( Classroom $classroom ){
       return $this->repository->getStats( $classroom->id );
    }
}
