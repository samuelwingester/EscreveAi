<?php

namespace App\Services\Student;

use App\Repositories\Query\QueryOptions;
use App\Repositories\StudentRepository;
use App\Models\Student;

class ListService
{
	public function execute( int|string $classroomId, ?QueryOptions $options = null, array $columns = ['*'] )
	{
        if ( !$columns ) $columns = ['*'];

        $query = Student::where( 'classroom_id', $classroomId );

        $total = $query->count();

        $data = $query->applyOptions( $options )->get( $columns ) ;

        return [ "data" => $data, "total" => $total, "count" => $data->count() ];
	}
}
