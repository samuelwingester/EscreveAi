<?php

namespace App\Services\Activity;

use Illuminate\Support\Facades\DB;

use App\Models\Activity;

class UpdateActivityService
{
	public function execute( Activity $activity, array $data ): Activity
	{
		return DB::transaction( function () use ( $activity, $data ){
			return $activity->update([
				'title' 		=> $data['title'] ?? $activity->title,
				'description' 	=> $data['description'] ?? $activity->description
			]);
		}, 2);
	}
}