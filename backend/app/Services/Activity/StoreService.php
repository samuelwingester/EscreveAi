<?php

namespace App\Services\Activity;

use App\Services\Attachment\AttachmentsHandlerService;
use App\Models\Classroom;
use App\Models\Activity;
use App\Models\User;

class StoreService
{
	public function __construct(
		protected AttachmentsHandlerService $attachmentsHandler
	) {}

	public function execute( User $user, Classroom $classroom, array $data ) : Activity
	{
		$activity = $classroom->activities()->create([
            'title' 		=> $data['title'],
			'description' 	=> $data['description']
        ]);

        $this->attachmentsHandler->execute( $user, $activity, $data['attachments'] ?? [] );

        return $activity;
	}
}
