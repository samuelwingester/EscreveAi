<?php

namespace App\Services\Classroom;

use App\Repositories\Contracts\ClassroomRepositoryInterface;

use App\Models\Classroom;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateClassroomService
{
	public function __construct(
		protected ClassroomRepositoryInterface $repository
	) {}

	/** @throws ModelNotFoundException */
	public function execute( Classroom $class, array $data ) : Classroom
	{
		return $this->repository->updateWithModel( $class, $data );
	}
}