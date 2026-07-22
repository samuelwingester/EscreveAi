<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\Student;
use App\Models\Teacher;

use App\Enums\UserType;
use App\Enums\Gender;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'birth_date',
        'gender',
        'secondary_email',
        'type'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'type' => UserType::class,
            'gender' => Gender::class,
        ];
    }

    //--------------------------------------------------------
    // Relacionamentos
    //--------------------------------------------------------
    public function student(): HasOne
    {
        return $this->hasOne( Student::class );
    }

    public function teacher(): HasOne
    {
        return $this->hasOne( Teacher::class );
    }
    //--------------------------------------------------------
}