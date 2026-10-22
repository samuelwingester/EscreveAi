<?php

namespace App\Services\Student;

use App\Models\Student;

class UpdateService
{
	public function execute( Student $student, array $data ) : Student
	{
		$student->update( $data );

        $student->refresh();

        return $student;
    }
}
