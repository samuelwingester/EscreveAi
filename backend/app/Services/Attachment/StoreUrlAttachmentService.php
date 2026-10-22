<?php

namespace App\Services\Attachment;

use Illuminate\Database\Eloquent\Model;

use App\Services\Attachment\StoreAttachmentService;
use App\Models\Attachment;
use App\Enums\StorageType;

class StoreUrlAttachmentService
{
	public function __construct(
		private StoreAttachmentService $store
	){}

	public function execute( Model $attachable, string $url ) : Attachment
	{
		$data['storage_type'] = StorageType::URL;
		$data['file_path'] = $url;

		return $this->store->execute( $attachable, $data );
	}
}
