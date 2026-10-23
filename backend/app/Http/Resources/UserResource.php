<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

use App\Http\Resources\BaseResource;

class UserResource extends BaseResource
{
    public static $wrap = 'user';

    /** @return array<string, mixed> */
    public function toArray( Request $request ): array
    {
        return [
            'id'              => $this->whenExists('id'),
            'name'            => $this->whenExists('name'),
            'email'           => $this->whenExists('email'),
            'gender'          => $this->whenExists('gender'),
            'secondary_email' => $this->whenExists('secondary_email'),
            'created_at'      => $this->whenExists('created_at'),
            'updated_at'      => $this->whenExists('updated_at'),
        ];
    }
}
