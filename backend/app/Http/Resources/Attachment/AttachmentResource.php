<?php

namespace App\Http\Resources\Attachment;

use Illuminate\Http\Request;

use App\Http\Resources\BaseResource;

class AttachmentResource extends BaseResource
{
    public static $wrap = 'attachment';

    /** @return array<string, mixed> */
    public function toArray( Request $request ): array
    {
        return [
            'id'        => $this->whenExists('id'),
            'file_name' => $this->whenExists('file_name'),
            'file_mime' => $this->whenExists('file_mime'),
            'file_path' => $this->whenExists('file_path')
        ];
    }
}
