<?php

namespace App\Services\Classroom;

use App\Repositories\Query\QueryOptions;
use App\Models\Classroom;

class ListService
{
	public function execute( int|string $teacherId, ?QueryOptions $options = null, array $columns = ['*'] )
	{
        if ( !$columns ) $columns = ['*'];

        $query = Classroom::where( 'teacher_id', $teacherId );

        $total = $query->count();

        $data = $query->applyOptions( $options )->get( $columns );

        return [ "data" => $data, "total" => $total, "count" => $data->count() ];
	}
}
