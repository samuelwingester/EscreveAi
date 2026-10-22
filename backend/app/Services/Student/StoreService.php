<?php

namespace App\Services\Student;

use App\Models\Classroom;
use App\Models\Student;

class StoreService
{
	public function execute( Classroom $classroom, array $data ) : Student
	{
		return $classroom->students()->create([
            'name' 			=> $data['name'],
            'writing_level' => $data['writing_level'] ?? null,
            'observations' 	=> $data['observations'] ?? null,
            'birth_date' 	=> $data['birth_date'],
        ]);
	}
}
