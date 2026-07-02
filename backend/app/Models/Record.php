<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Student;
use App\Models\Activity;
use App\Models\Analysis;

class Record extends Model
{
    use HasFactory;

    protected $table = 'records';

    protected $fillable = [
        'student_id',
        'activity_id',
        'file_path',
    ];

    public function student()
    {
        return $this->belongsTo( Student::class, 'student_id' );
    }

    public function activity()
    {
        return $this->belongsTo( Activity::class, 'activity_id' );
    }

    public function analysis()
    {
        return $this->hasOne( Analysis::class );
    }
}
