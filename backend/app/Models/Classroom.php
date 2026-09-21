<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

use Database\Factories\ClassroomFactory;

use App\Policies\ClassroomPolicy;
use App\Models\Enums\Shift;
use App\Models\Activity;
use App\Models\Student;
use App\Models\User;

#[UsePolicy(ClassroomPolicy::class)]
class Classroom extends Model
{
    /** @use HasFactory<ClassroomFactory> */
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'teacher_id',
        'name',
        'school',
        'shift',
        'active'
    ];

    /** @return array<string, string> */
    protected function casts() : array
    {
        return [
            'active' => 'boolean',
            'shift' => Shift::class
        ];
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo( User::class, 'teacher_id' ); // aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
    }

    public function students() : HasMany
    {
        return $this->hasMany( Student::class );
    }

    public function activities() : HasMany
    {
        return $this->hasMany( Activity::class );
    }
}
