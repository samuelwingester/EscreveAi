<?php

namespace App\Service\Record;

use App\Services\Attachment\AttachmentsHandlerService as AttachmentHandler;
use App\Models\Record;

class UpdateRecordService{
    public function __construct(
        private AttachmentHandler $attachmentHandler
    ) {}

    public function execute( Record $record, array $data ){
        $this->attachmentHandler->execute( $record, $data['attachments'] ?? [] );
    }
}