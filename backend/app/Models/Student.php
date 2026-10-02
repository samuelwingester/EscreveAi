<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

use Database\Factories\StudentFactory;

use App\Models\Enums\WritingLevel;
use App\Models\Classroom;
use App\Models\Report;
use App\Models\Record;

class Student extends Model
{
    /** @use HasFactory<StudentFactory> */
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'classroom_id',
        'name',
        'writing_level',
        'observations',
    ];

     /** @return array<string, string> */
    protected function casts() : array
    {
        return [
            'writing_level' => WritingLevel::class
        ];
    }

    public function classroom() : BelongsTo
    {
        return $this->belongsTo( Classroom::class );
    }

    public function records(): HasMany
    {
        return $this->hasMany( Record::class );
    }

    public function reports(): HasMany
    {
        return $this->hasMany( Report::class );
    }
}

