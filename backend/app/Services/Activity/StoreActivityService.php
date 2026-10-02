<?php

namespace App\Services\Activity;

use Illuminate\Support\Facades\DB;

use App\Repositories\Contracts\ActivityRepositoryInterface;
use App\Services\Attachment\AttachmentsHandlerService as AttachmentHandler;
use App\Models\Activity;

class StoreActivityService
{
	public function __construct(
		protected ActivityRepositoryInterface $repository,
		protected AttachmentHandler $attachmentsHandler
	) {}

	public function execute( array $data ): Activity
	{
		return DB::transaction( function () use ( $data ) {
			$activity = $this->repository->create([
				'class_id' 		=> $data['class_id'],
				'title' 		=> $data['title'],
				'description' 	=> $data['description']
			]);

			$this->attachmentsHandler->execute( $activity, $data['attachments'] ?? [] );

			return $activity;
		}, 2);
	}
}