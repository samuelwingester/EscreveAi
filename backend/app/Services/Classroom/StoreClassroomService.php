<?php

namespace App\Services\Classroom;

use App\Repositories\Contracts\ClassroomRepositoryInterface;

use App\Models\Classroom;
use App\Models\User;

class StoreClassroomService
{
	public function __construct(
		protected ClassroomRepositoryInterface $repository
	) {}

	public function execute( User $teacher, string $name ) : Classroom
	{
		return $this->repository->create( [ 'name' => $name, 'teacher_id' => $teacher->id ] );
	}
}