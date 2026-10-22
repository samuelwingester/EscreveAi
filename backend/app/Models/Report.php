<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

use App\Models\Contracts\HasAttachmentsContract;
use App\Models\Traits\HasAttachments;
use App\Models\Student;

class Report extends Model implements HasAttachmentsContract
{
    use HasFactory;
    use HasAttachments;

    protected $table = 'reports';

    protected $fillable = [
        'student_id',
        'start_date',
        'end_date',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date'
        ];
    }

    //--------------------------------------------------------
    // Relacionamentos
    //--------------------------------------------------------
    public function student(): BelongsTo
    {
        return $this->belongsTo( Student::class, 'student_id' );
    }

    public function analysis()
    {
        return; // implementar depois. um pouco mais chato
    }
    //--------------------------------------------------------
}
