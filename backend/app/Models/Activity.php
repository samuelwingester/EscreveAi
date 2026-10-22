<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

use App\Models\Contracts\HasAttachmentsContract;
use App\Models\Traits\AppliesQueryOptions;
use App\Models\Traits\HasAttachments;
use App\Models\Classroom;
use App\Models\Record;

class Activity extends Model implements HasAttachmentsContract
{
    use HasFactory;
    use HasAttachments;
    use AppliesQueryOptions;

    protected $table = 'activities';

    protected $fillable = [
        'title',
        'description',
    ];

    //--------------------------------------------------------
    // Relacionamentos
    //--------------------------------------------------------
    public function classroom(): BelongsTo
    {
        return $this->belongsTo( Classroom::class, 'classroom_id' );
    }

    public function records(): HasMany
    {
        return $this->hasMany( Record::class );
    }
    //--------------------------------------------------------
}
