<?php

namespace App\Services\Classroom;

use App\Models\Classroom;

class UpdateClassroomService
 {
	public static function execute( Classroom $classroom, array $data )
	{
		$classroom->fill($data);
		
		$classroom->saveOrFail();

		return response()->json($classroom, 202);
	}
}