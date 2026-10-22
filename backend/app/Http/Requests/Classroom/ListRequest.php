<?php

namespace App\Http\Requests\Classroom;

use App\Http\Requests\BaseListRequest;

class ListRequest extends BaseListRequest
{
    public array $orderByFields {
        get => [ 'id', 'name', 'school', 'shift', 'created_at', ];
    }

    public array $acceptedFields {
        get => [ 'id', 'name', 'school', 'shift', 'active', ];
    }
}

