<?php

namespace App\Services\Attachment;

use Illuminate\Database\Eloquent\Model;

use App\Services\Attachment\StoreFileAttachmentService as StoreFile;
use App\Services\Attachment\StoreUrlAttachmentService as StoreUrl;

class AttachmentsHandlerService
{
	public function __construct(
		private StoreUrl $urlService,
		private StoreFile $fileService
	){}

	public function execute( Model $model, array $data ) : void
	{
		foreach( $data ?? [] as $attachment ){
            if ( !empty($attachment['url']) )
                $this->urlService->execute( $model, $attachment['url'] );
            else if ( !empty($attachment['file']) )
                $this->fileService->execute( $model, $attachment['file'] );  	        
        }
	}
}