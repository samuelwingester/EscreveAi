<?php

namespace App\Services\Classroom;

use App\Models\Classroom;

class UpdateService
{
	public function execute( Classroom $classroom, array $data ) : Classroom
	{
		$classroom->update( $data );

        $classroom->refresh();

        return $classroom;
    }
}
