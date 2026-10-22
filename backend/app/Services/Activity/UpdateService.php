<?php

namespace App\Services\Activity;

use App\Services\Attachment\AttachmentsHandlerService;
use App\Models\Activity;

class UpdateService
{
	public function __construct(
		protected AttachmentsHandlerService $attachmentsHandler
	) {}

	public function execute( Activity $activity, array $data )
	{
        $activity->update( $data );

        $activity->refresh();

        $this->attachmentsHandler->execute( $activity, $data['attachments'] ?? [] );

        return $activity;
	}
}
