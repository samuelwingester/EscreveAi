<?php

namespace App\Services\Authentication;

use Exception;

use Illuminate\Support\Facades\Log;

use App\Services\Attachment\DeleteAttachmentService;
use App\Models\User;

class DeleteService
{
    public function __construct(
        private DeleteAttachmentService $delete_attachment
    ) {}

    public function execute(User $user): bool
    {
        // Codigo ruim, mas fds
        foreach ( $user->attachments as $attachment ) {
            try {
                $this->delete_attachment->execute( $attachment );
            }
            catch (Exception $e)
            {
                $message = "Falha ao deletar anexo: {$attachment->id}: " . $e->getMessage();

                Log::critical($message, [
                    'user_id' => $user->id,
                    'attachment_id' => $attachment->id,
                    'exception' => $e,
                ]);
            }
        }

        return $user->deleteOrFail();
    }
}
