<?php

namespace App\Service\Record;

use App\Models\Record;

use App\Services\Attachment\AttachmentsHandlerService as AttachmentHandler;
use App\Repositories\Contracts\RecordRepositoryInterface;

use Illuminate\Support\Facades\DB;

class StoreRecordService{

    public function __construct(
        private RecordRepositoryInterface $repository,
        private AttachmentHandler $attachmentHandler
    ) {}

    public static function execute( array $data ): Record{
        return DB::transaction( function () use ( $data ) {
            $record = $this->repository->create([
                'student_id'    => $data['student_id'],
                'activity_id'   => $data['activity_id']
            ]);

            $this->attachmentHandler->execute( $record, $data['attachments'] ?? [] );

            return $record;
        }, 2);
    }
}