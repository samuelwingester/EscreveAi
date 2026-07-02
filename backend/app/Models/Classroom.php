<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Teacher;
use App\Models\Activity;

class Classroom extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'active',
        'teacher_id'
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'name' => 'string'
        ];
    }

    public function teacher()
    {
        return $this->belongsTo( Teacher::class, 'teacher_id' );
    }

    public function activities()
    {
        return $this->hasMany( Activity::class );
    }
}
