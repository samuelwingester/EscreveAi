<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\BaseListRequest;

class ListRequest extends BaseListRequest
{
    public array $orderByFields {
        get => [ 'id', 'name', 'writing_level', 'birth_date', 'created_at' ];
    }

    public array $acceptedFields {
        get => [ 'id', 'name', 'writing_level', 'birth_date' ];
    }
}
