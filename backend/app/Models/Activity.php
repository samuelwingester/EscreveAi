<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Classroom;
use App\Models\Record;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'class_id'
    ];

    public function class()
    {
        $this->belongsTo( Classroom::class, 'class_id' );
    }

    public function records()
    {
        return $this->hasMany( Record::class );
    }
}
