<?php

namespace App\Services\Attachment;

use Illuminate\Support\Facades\Storage;

use App\Models\Attachment;

use App\Enums\StorageType;

class DeleteAttachmentService
{
	public function execute( Attachment $attachment ): bool
	{
		$success = true;

		if ( $attachment->storage_type == StorageType::LOCAL )
			$success = Storage::disk( $attachment->disk_type )->delete( $attachment->file_path );

		$attachment->deleteOrFail();

		return $success;
	}
}