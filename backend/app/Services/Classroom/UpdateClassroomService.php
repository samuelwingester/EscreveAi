<?php

namespace App\Services\Classroom;

use Illuminate\Support\Facades\DB;

use App\Models\Classroom;

class UpdateClassroomService
 {
	public function execute( array $data, Classroom $classroom ) : Classroom
	{
		return DB::transaction( function () use( $data, $classroom ) {
			return ([ 
				'name' 		=> $data['name'] ?? $classroom->name,
				'active' 	=> $data['active'] ?? $classroom->active
			]);
		}, 2);
	}
}