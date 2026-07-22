<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

use App\Models\Classroom;
use App\Models\Record;
use App\Models\Attachment;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';

    protected $fillable = [
        'title',
        'description',
        'class_id'
    ];

    //--------------------------------------------------------
    // Relacionamentos
    //--------------------------------------------------------
    public function class(): BelongsTo
    {
        return $this->belongsTo( Classroom::class, 'class_id' );
    }

    public function records(): HasMany
    {
        return $this->hasMany( Record::class );
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany( Attachment::class, 'attachable' );
    }
    //--------------------------------------------------------
}
