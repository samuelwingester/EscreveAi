<?php

namespace App\Services\Attachment;

use Illuminate\Database\Eloquent\Model;

use App\Models\Attachment;

use App\Services\Attachment\StoreAttachmentService;

use App\Enums\StorageType;

class StoreUrlAttachmentService
{
	public function __construct(
		private StoreAttachmentService $storeService = new StoreAttachmentService
	){}

	public function execute( Model $attachable, string $url ) : Attachment
	{
		// NT: fodase o nome e o tipo. complicado demais.
		$data['storage_type'] = StorageType::URL;
		$data['file_path'] = $url;

		return $this->storeService->execute( $attachable, $data );
	}
}