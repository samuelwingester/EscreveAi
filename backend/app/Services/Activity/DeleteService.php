<?php

namespace App\Services\Activity;

use App\Services\Attachment\DeleteAttachmentService;
use App\Models\Activity;

class DeleteService
{
    public function __construct(
        protected DeleteAttachmentService $deleteAttachment
    ) {}

	public function execute( Activity $activity ) : bool
	{
        foreach( $activity->attachments() as $att )
        {
            $this->deleteAttachment->execute( $att );
        }

		return $activity->deleteOrFail();
	}
}
