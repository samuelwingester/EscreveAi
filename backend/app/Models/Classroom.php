<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#use App\Models\Teacher;
use App\Models\Activity;
use App\Models\Student;
use App\Models\User;

use App\Policies\ClassroomPolicy;

#[UsePolicy(ClassroomPolicy::class)]
class Classroom extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'active',
        'teacher_id',
        'shift'
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'name' => 'string'
        ];
    }

    //--------------------------------------------------------
    // Relacionamentos
    //--------------------------------------------------------
    /*
    public function teacher(): BelongsTo
    {
        return $this->belongsTo( User::class, 'teacher_id' );
    }*/


    public function user(): BelongsTo
    {
        return $this->belongsTo( User::class, 'teacher_id' );
    }


    public function activities(): HasMany
    {
        return $this->hasMany( Activity::class, 'class_id' );
    }

    public function students(): HasMany
    {
        return $this->hasMany( Student::class, 'class_id' );
    }
    //--------------------------------------------------------
}
