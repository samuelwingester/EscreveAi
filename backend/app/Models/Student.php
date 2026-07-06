<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Classroom;
use App\Models\User;
use App\Models\Record;
use App\Models\Report;

use App\Enums\WritingLevel;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'user_id',
        'class_id',
        'writing_level',
        'observations'
    ];

    protected function casts(): array
    {
        return [
            'writing_level' => WritingLevel::class
        ];
    }

    public function user()
    {
        return $this->belongsTo( User::class, 'user_id' );
    }

    public function class()
    {
        return $this->belongsTo( Classroom::class, 'class_id' );
    }

    public function records()
    {
        return $this->hasMany( Record::class );
    }

    public function reports()
    {
        return $this->hasMany( Report::class );
    }
}
