<?php

namespace App\Services\Student;

use Illuminate\Support\Facades\DB;

use App\Models\Student;

use App\Repositories\Contracts\StudentRepositoryInterface;

class StoreStudentService
{
    public function __construct(
		protected StudentRepositoryInterface $repository
	) {}

	public function execute( array $data ) : Student
	{
		// Tenta inserir as informações do novo usuario
		return $this->repository->create([
            'name' 			=> $data['name'],
            'class_id' 		=> $data['class_id'],
            'writing_level' => $data['writing_level'] ?? null,
            'observations' 	=> $data['observations'] ?? null,
            'birth_date' 	=> $data['birth_date'],
        ]);
	}
}
