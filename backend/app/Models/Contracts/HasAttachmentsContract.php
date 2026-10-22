<?php

namespace App\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasAttachmentsContract
{
    public function attachments() : MorphMany;
}
