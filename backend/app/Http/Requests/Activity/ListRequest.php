<?php

namespace App\Http\Requests\Activity;

use App\Http\Requests\BaseListRequest;

class ListRequest extends BaseListRequest
{
    public array $orderByFields {
        get => [ 'title', 'created_at' ];
    }

    public array $acceptedFields {
        get => [ 'title', 'description', 'id', 'attachments' ];
    }
}
