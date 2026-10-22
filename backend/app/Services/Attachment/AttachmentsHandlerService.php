<?php

namespace App\Services\Attachment;

use InvalidArgumentException;

use Illuminate\Database\Eloquent\Model;

use App\Services\Attachment\StoreFileAttachmentService;
use App\Services\Attachment\StoreUrlAttachmentService;
use App\Models\Contracts\HasAttachmentsContract;

class AttachmentsHandlerService
{
	public function __construct(
		private StoreUrlAttachmentService $storeUrl,
		private StoreFileAttachmentService $storeFile
	){}

	public function execute( Model $model, array $data ) : void
	{
        if (! $model instanceof HasAttachmentsContract) {
            throw new InvalidArgumentException( 'Este model não suporta anexos.' );
        }

		foreach( $data ?? [] as $attachment ){
            if ( !empty($attachment['url']) )
            {
                $this->storeUrl->execute( $model, $attachment['url'] );
            }
            else if ( !empty($attachment['file']) )
            {
                $this->storeFile->execute( $model, $attachment['file'] );
            }
        }
	}
}
