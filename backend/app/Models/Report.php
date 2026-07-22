<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

use App\Models\Student;
use App\Models\Attachment;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    protected $fillable = [
        'student_id',
        'teacher_id',
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

    public function analyses() // NT: Olhar com o kaique
    {
        return; // implementar depois. um pouco mais chato
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany( Attachment::class, 'attachable' );
    }
    //--------------------------------------------------------
}
