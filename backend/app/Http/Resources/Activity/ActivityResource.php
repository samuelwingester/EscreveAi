<?php

namespace App\Http\Resources\Activity;

/**
 * TO DO
 * - Ver como vou fazer para puxar os dados dos anexos
 */

use Illuminate\Http\Request;

use App\Http\Resources\Attachment\AttachmentResource;
use App\Http\Resources\BaseResource;

class ActivityResource extends BaseResource
{
    public static $wrap = 'activity';

    /** @return array<string, mixed> */
    public function toResource( Request $request ): array
    {
        return [
            'id'            => $this->whenExists('id'),
            'title'         => $this->whenExists('title'),
            'description'   => $this->whenExists('description'),
            'preview_url'   => $this->whenExists('preview_url'), // a implementar
            'attachments'   => new AttachmentResource( $this->whenLoaded('attachments') )
        ];
    }
}
