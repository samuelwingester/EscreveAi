<?php

namespace App\Services\Classroom;

use Illuminate\Support\Facades\DB;

use App\Models\Classroom;
use App\Models\Teacher;

class StoreClassroomService
 {
	public function execute( Teacher $teacher, string $name ) : Classroom
	{
		return DB::transaction( function () use( $name, $teacher ) {
			return $teacher->classes()->create( [ 'name' => $name ] );
		}, 2);
	}
}