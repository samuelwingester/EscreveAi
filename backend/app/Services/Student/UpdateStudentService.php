<?php

namespace App\Services\Student;

use Illuminate\Support\Facades\DB;

use App\Models\Student;

use App\Repositories\Contracts\StudentRepositoryInterface;

class UpdateStudentService
 {
    public function __construct(
		protected StudentRepositoryInterface $repository
	) {}

	public function execute( array $data, Student $student ) : object
	{
		// Tenta atualizar as informações do usuario
		return $this->repository->updateWithModel( $student, [
            'name' 			=> $data['name'] ?? $student->name,
            'class_id' 		=> $data['class_id'] ?? $student->class_id,
            'writing_level' => $data['writing_level'] ?? $student->writing_level,
            'observations' 	=> $data['observations'] ?? $student->observations
        ]);
	}
}
