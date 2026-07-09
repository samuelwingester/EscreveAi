<?php

namespace App\Services\Classroom;

use Illuminate\Support\Facades\DB;

use App\Models\Classroom;
use App\Models\Teacher;

class StoreClassroomService
 {
	public function execute( array $data, Teacher $teacher ) : Classroom
	{
		return DB::transaction( function () use( $data, $teacher ) {
			return $teacher->classes()->create( [ 'name' => $data['name'] ] );
		}, 2);
	}
}