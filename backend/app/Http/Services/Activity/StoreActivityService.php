<?php

namespace App\Services\Activity;

use Illuminate\Support\Facades\DB;

use App\Models\Classroom;

class StoreActivityService
{
	public function execute( Classroom $classroom, array $data )
	{
		return DB::transaction( function () use ( $classroom, $data ) {
			return $classroom->activities()->create([
				'title' 		=> $data['title'],
				'description' 	=> $data['description']
			]);
		}, 2);
	}
}