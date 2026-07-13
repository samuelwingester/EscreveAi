<?php

namespace App\Services\Classroom;

use Illuminate\Support\Facades\DB;

use App\Models\Classroom;

class UpdateClassroomService
 {
	public function execute( array $data, Classroom $classroom ) : bool
	{
		return DB::transaction( function () use( $data, $classroom ) {
			return $classroom->update([ 
				'name' 		=> $data['name'] ?? $classroom->name,
				'active' 	=> $data['active'] ?? $classroom->active
			]);
		}, 2);
	}
}