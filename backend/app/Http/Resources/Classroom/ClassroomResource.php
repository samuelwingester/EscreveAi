<?php

namespace App\Http\Resources\Classroom;

use Illuminate\Http\Request;

use App\Http\Resources\BaseResource;

class ClassroomResource extends BaseResource
{
    public static $wrap = 'classroom';

    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id'     => $this->whenExists('id'),
            'name'   => $this->whenExists('name'),
            'school' => $this->whenExists('school'),
            'shift'  => $this->whenExists('shift'),
            'active' => $this->whenExists('active'),
        ];
    }
}
