<?php

namespace App\Services\Teacher;

use Illuminate\Support\Facades\DB;

use App\Models\Teacher;

class UpdateTeacherService
 {
	public function execute( array $data, Teacher $teacher )
	{
		// Tenta atualizar as informações do usuario
		return DB::transaction( function () use ( $data, $teacher ) {
			return $teacher->user()->update([
				'secondary_email' 	=> $data['secondary_email'] ?? $teacher->secondary_email,
				'name' 				=> $data['name'] ?? $teacher->name,
				'gender' 			=> $data['gender'] ?? $teacher->gender,
				'birth_date' 		=> $data['birth_date'] ?? $teacher->birth_date
			]);
		}, 2);
	}
}