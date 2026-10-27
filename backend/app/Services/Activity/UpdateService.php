<?php

namespace App\Services\Activity;

use App\Services\Attachment\AttachmentsHandlerService;
use App\Models\Activity;
use App\Models\User;

class UpdateService
{
	public function __construct(
		protected AttachmentsHandlerService $attachmentsHandler
	) {}

	public function execute( User $user, Activity $activity, array $data )
	{
        $activity->update( $data );

        $activity->refresh();

        $this->attachmentsHandler->execute( $user, $activity, $data['attachments'] ?? [] );

        return $activity;
	}
}
