<?php

namespace App\Services\Classroom;

use App\Models\Classroom;

class DeleteService
{
	public function execute( Classroom $classroom ) : bool
	{
		return $classroom->deleteOrFail();
	}
}
