<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

use App\Models\Student;
use App\Models\Activity;
use App\Models\Analysis;
use App\Models\Attachment;

class Record extends Model
{
    use HasFactory;

    protected $table = 'records';

    protected $fillable = [
        'student_id',
        'activity_id',
    ];

    //--------------------------------------------------------
    // Relacionamentos
    //--------------------------------------------------------
    public function student(): BelongsTo
    {
        return $this->belongsTo( Student::class, 'student_id' );
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo( Activity::class, 'activity_id' );
    }

    public function analysis(): HasOne
    {
        return $this->hasOne( Analysis::class );
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
    //--------------------------------------------------------
}
