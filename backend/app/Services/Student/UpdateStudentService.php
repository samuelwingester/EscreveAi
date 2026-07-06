<?php

namespace App\Services\Student;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Student;
use App\Models\User;

class UpdateStudentService
 {
	public function execute( array $data, Student $student ) : Student
	{
		// Tenta atualizar as informações do usuario
		return DB::transaction( function () use ( $data, $student ) {
			$user = $student->user();

			// Atualização do usuario
			$user->update([
				'secondary_email' 	=> $data['secondary_email'] ?? $user->secondary_email,
				'name' 				=> $data['name'] ?? $user->name,
				'gender' 			=> $data['gender'] ?? $user->gender,
				'birth_date' 		=> $data['birth_date'] ?? $user->birth_date
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