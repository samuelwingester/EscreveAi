<?php

namespace App\Services\Teacher;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Teacher;
use App\Models\User;

use App\Enums\UserType;

class StoreTeacherService
 {
	public function execute( array $data )
	{
		// Tenta inserir as informações do novo usuario
		return DB::transaction( function () use ( $data ) {
			// Inserção do novo usuario
			$user = User::create([
				'email' 		=> $data['email'],
				'password' 		=> Hash::make( $data['password'] ),
				'name' 			=> $data['name'],
				'gender' 		=> $data['gender'] ?? null,
				'birth_date' 	=> $data['birth_date'],
				'type'			=> UserType::TEACHER
			]);
			//

			// Inserção das informações especificas do tipo de usuario
			return $user->teacher()->create();
			//
		}, 2);
	}
}