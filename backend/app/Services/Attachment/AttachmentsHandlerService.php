<?php

namespace App\Services\Attachment;

use App\Models\Activity;

use App\Services\Attachment\StoreFileAttachmentService;
use App\Services\Attachment\StoreUrlAttachmentService;

class AttachmentsHandlerService
{
	public function __construct(
		private StoreUrlAttachmentService $urlService,
		private StoreFileAttachmentService $fileService
	){}

	public function execute( Activity $activity, array $data ) : void
	{
		foreach( $data ?? [] as $attachment ){
            if ( !empty($attachment['url']) )
                $this->urlService->execute( $activity, $attachment['url'] );
            else if ( !empty($attachment['file']) )
                $this->fileService->execute( $activity, $attachment['file'] );  	        
        }
	}
}