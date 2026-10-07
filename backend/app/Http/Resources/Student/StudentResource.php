<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Request;

use App\Http\Resources\BaseResource;

class StudentResource extends BaseResource
{
    public static $wrap = 'student';

    /** @return array<string, mixed> */
    public function toArray( Request $request ): array
    {
        return [
            'id'            => $this->whenExists('id'),
            'name'          => $this->whenExists('name'),
            'birth_date'    => $this->whenExists('birth_date'),
            'writing_level' => $this->whenExists('writing_level'),
            'observations'  => $this->whenExists('observations')
        ];
    }
}
