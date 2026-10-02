<?php

namespace App\Services\Classroom;

use App\Repositories\Contracts\ClassroomRepositoryInterface;
use App\Models\Classroom;

class UpdateService
{
	public function __construct(
		protected ClassroomRepositoryInterface $repository
	) {}

	public function execute( Classroom $class, array $data ) : Classroom
	{
		return $this->repository->updateWithModel( $class, $data );
	}
}
