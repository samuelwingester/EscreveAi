<?php

namespace App\Http\Resources\Activity;

/**
 * TO DO
 * - Ver como vou fazer para puxar os dados dos anexos
 */

use Illuminate\Http\Request;

use App\Http\Resources\BaseResource;

class ActivityResource extends BaseResource
{
    public static $wrap = 'activity';

    /** @return array<string, mixed> */
    public function toArray( Request $request ): array
    {
        return [
            'id'            => $this->whenExists('id'),
            'title'         => $this->whenExists('title'),
            'description'   => $this->whenExists('description'),
        ];
    }
}
