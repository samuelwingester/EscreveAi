<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Student;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    protected $fillable = [
        'student_id',
        'teacher_id',
        'start_date',
        'end_date',
        'file_path'
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date'
        ];
    }

    public function student()
    {
        return $this->belongsTo( Student::class, 'student_id' ); 
    }

    public function analyses()
    {
        return; // implementar depois. um pouco mais chato
    }
}
