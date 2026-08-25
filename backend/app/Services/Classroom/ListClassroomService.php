<?php

namespace App\Services\Classroom;

use App\Repositories\Contracts\ClassroomRepositoryInterface;

use App\Models\User;

class ListClassroomService
{
	public function __construct(
		protected ClassroomRepositoryInterface $repository
	) {}

	public function execute( User $teacher )
	{
		return $this->repository->getWithTeacherId( $teacher->id );
	}
}
