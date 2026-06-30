<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Table('students')]
class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birth_date',
        'secondary_email',
        'user_id'
    ];

}
