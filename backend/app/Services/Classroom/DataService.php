<?php

namespace App\Services\Classroom;

use App\Models\Classroom;
use App\Repositories\Contracts\ClassroomRepositoryInterface;

use App\Models\User;

use App\Repositories\Query\QueryOptions;

class DataService
{
	public function __construct(
		protected ClassroomRepositoryInterface $repository
	) {}

	public function list( User $teacher, array $options = [], array $columns = ['*'] )
	{
        if ( !$columns ) $columns = ['*'];

        $total = $this->repository->getCountWhere( [[ "teacher_id", "=", $teacher->id ]] );

        $data = $this->repository->getByTeacher( $teacher->id, [], $columns, $this->makeQueryOptions( $options ) );

        return [ "data" => $data, "total" => $total, "count" => $data->count() ];
	}

    public function generateStats( Classroom $classroom )
    {
        // Gambiarra
        return (array) $this->repository->getStats( $classroom->id );
    }

    private function makeQueryOptions( array $options = [] ){
        $queryOptions = new QueryOptions();

        if ( $options["limit"] )
            $queryOptions->limit = $options["limit"];

        if ( $options["offset"] )
            $queryOptions->offset = $options["offset"];

        if ( $options["order_by"] )
            $queryOptions->orderBy = $options["order_by"];

        if ( $options["direction"] )
            $queryOptions->direction = $options["direction"];

        return $queryOptions;
    }
}
