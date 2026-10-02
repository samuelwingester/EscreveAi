<?php

namespace App\Services\Classroom;

use App\Repositories\Contracts\ClassroomRepositoryInterface;
use App\Models\Classroom;
use App\Models\User;

class StoreService
{
	public function __construct(
		protected ClassroomRepositoryInterface $repository
	) {}

	public function execute( User $teacher, array $data ) : Classroom
	{
		return $this->repository->create([
            'name'          => $data['name'],
            'teacher_id'    => $teacher->id,
            'shift'         => $data['shift'],
            'school'        => $data['school'] ?? null
        ]);
	}
}
