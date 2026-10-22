<?php

namespace App\Services\Classroom;

use App\Models\Classroom;
use App\Models\User;

class StoreService
{
	public function execute( User $teacher, array $data ) : Classroom
	{
		return $teacher->classes()->create([
            'name'          => $data['name'],
            'shift'         => $data['shift'],
            'school'        => $data['school'] ?? null
        ]);
	}
}
