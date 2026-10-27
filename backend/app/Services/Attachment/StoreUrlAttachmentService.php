<?php

namespace App\Services\Attachment;

use Illuminate\Database\Eloquent\Model;

use App\Services\Attachment\StoreAttachmentService;
use App\Enums\StorageType;
use App\Models\Attachment;
use App\Models\User;

class StoreUrlAttachmentService
{
	public function __construct(
		private StoreAttachmentService $store
	){}

	public function execute(
		User $user,
		Model $attachable,
		string $url
	) : Attachment
	{
		$data['storage_type'] = StorageType::URL;
		$data['file_path'] = $url;
		$data['user_id'] = $user->id;

		return $this->store->execute( $attachable, $data );
	}
}
