<?php

namespace App\Services\Attachment;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Filesystem\FilesystemAdapter;

class FindAttachmentService
{
    public function upload( Attachment $attachment ) : StreamedResponse
    {
        $disk = $this->getDisk( $attachment );

        return $disk->response(
            $attachment->file_path,
            $this->getFileName( $attachment ),
            [
                'Content-Type' => $disk->mimeType( $attachment->file_path ) ?: 'application/octet-stream',
                'Content-Disposition' => 'inline',
                'X-Content-Type-Options' => 'nosniff',
            ]
        );
    }

    public function download( Attachment $attachment )
    {
        $disk = $this->getDisk( $attachment );

        return $disk->download(
            $attachment->file_path,
            $this->getFileName( $attachment ),
            [
                'Content-Type' => $disk->mimeType( $attachment->file_path ) ?: 'application/octet-stream',
                'X-Content-Type-Options' => 'nosniff',
            ]
        );
    }

    private function getDisk( Attachment $attachment ) : FilesystemAdapter
    {
        $disk = Storage::disk( $attachment->disk_type->value );

        abort_unless( $disk->exists($attachment->file_path), 404, 'Arquivo não encontrado.' );

        return $disk;
    }

    private function getFileName( Attachment $attachment ): string
    {
        return $attachment->file_extension ?
               $attachment->file_name . '.' . $attachment->file_extension
               : $attachment->file_name;
    }
}
