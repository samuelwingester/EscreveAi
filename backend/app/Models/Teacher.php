<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\User;
use App\Models\Classroom;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    protected $fillable = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo( User::class, 'user_id' );
    }

    public function classes()
    {
        return $this->hasMany( Classroom::class );
    }
}
