<?php

namespace App\Services\Student;

use Illuminate\Support\Facades\DB;

use App\Models\Student;

class UpdateStudentService
 {
	public function execute( array $data, Student $student ) : Student
	{
		// Tenta atualizar as informações do usuario
		return DB::transaction( function () use ( $data, $student ) {
			// Atualização do usuario
			$student->user()->update([
				'secondary_email' 	=> $data['secondary_email'] ?? $student->secondary_email,
				'name' 				=> $data['name'] ?? $student->name,
				'gender' 			=> $data['gender'] ?? $student->gender,
				'birth_date' 		=> $data['birth_date'] ?? $student->birth_date
			]);
			//

			// Atualização das informações especificas do tipo de usuario
			return $student->update([
				'class_id' 		=> $data['class_id'] ?? $student->class_id,
				'writing_level' => $data['writing_level'] ?? $student->writing_level,
				'observations' 	=> $data['observations'] ?? $student->observations
			]);
			//
		}, 2);
	}
}