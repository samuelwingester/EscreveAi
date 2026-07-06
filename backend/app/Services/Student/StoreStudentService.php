<?php

namespace App\Services\Student;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Student;
use App\Models\User;

class StoreStudentService
 {
	public function execute( array $data ) : Student
	{
		// Tenta inserir as informações do novo usuario
		return DB::transaction( function () use ( $data ) {
			// Inserção do novo usuario
			$user = User::create([
				'email' 		=> $data['email'],
				'password' 		=> Hash::make( $data['password'] ),
				'name' 			=> $data['name'],
				'gender' 		=> $data['gender'] ?? null,
				'birth_date' 	=> $data['birth_date']
			]);
			//

			// Inserção das informações especificas do tipo de usuario
			return $user->student()->create([
				'class_id' 		=> $data['class_id'],
				'writing_level' => $data['writing_level'] ?? null,
				'observations' 	=> $data['observations'] ?? null
			]);
			//
		}, 2);
	}
}