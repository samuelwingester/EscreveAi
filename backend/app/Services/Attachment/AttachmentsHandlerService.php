<?php

namespace App\Services\Attachment;

use InvalidArgumentException;

use Illuminate\Database\Eloquent\Model;

use App\Services\Attachment\StoreFileAttachmentService;
use App\Services\Attachment\StoreUrlAttachmentService;
use App\Models\Contracts\HasAttachmentsContract;
use App\Models\User;

class AttachmentsHandlerService
{
	public function __construct(
		private StoreUrlAttachmentService $storeUrl,
		private StoreFileAttachmentService $storeFile
	){}

	public function execute( User $user, Model $model, array $data ) : void
	{
        if (! $model instanceof HasAttachmentsContract) {
            throw new InvalidArgumentException( 'Este model não suporta anexos.' );
        }

		foreach( $data ?? [] as $attachment ){
            if ( !empty($attachment['url']) )
            {
                $this->storeUrl->execute( $user, $model, $attachment['url'] );
            }
            else if ( !empty($attachment['file']) )
            {
                $this->storeFile->execute( $user, $model, $attachment['file'] );
            }
        }
	}
}
