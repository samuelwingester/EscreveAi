<?php

namespace App\Services\Activity;

use App\Repositories\Query\QueryOptions;
use App\Models\Activity;

class ListService
{
	public function execute( int|string $classroomId, ?QueryOptions $options = null, array $columns = ['*'] )
	{
        if ( !$columns ) $columns = ['*'];

        $query = Activity::where( 'classroom_id', $classroomId );

        $total = $query->count();

        // with provavelmente vai ser temporario, devo colocar um if pra decidir se carrega ou não a relação
        $data = $query->with( 'attachments' )->applyOptions( $options )->get( $columns );

        return [ "data" => $data, "total" => $total, "count" => $data->count() ];
	}
}
