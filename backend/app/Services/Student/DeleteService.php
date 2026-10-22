<?php

namespace App\Services\Student;

use App\Models\Student;

class DeleteService
{
	public function execute( Student $student ) : bool
	{
		return $student->deleteOrFail();
	}
}
