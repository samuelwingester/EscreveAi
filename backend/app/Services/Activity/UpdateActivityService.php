<?php

namespace App\Services\Activity;

use Illuminate\Support\Facades\DB;


use App\Repositories\Contracts\ActivityRepositoryInterface;
use App\Services\Attachment\AttachmentsHandlerService as AttachmentHandler;
use App\Models\Activity;

class UpdateActivityService
{
	public function __construct(
		protected ActivityRepositoryInterface $repository,
		protected AttachmentHandler $attachmentsHandler
	) {}

	public function execute( Activity $activity, array $data )
	{
		return DB::transaction( function () use ( $activity, $data ){
			$activity = $this->repository->updateWithModel( $activity, [
				'title' 		=> $data['title'] ?? $activity->title,
				'description' 	=> $data['description'] ?? $activity->description
			]);

			$this->attachmentsHandler->execute( $activity, $data['attachments'] ?? [] );
		}, 2);
	}
}