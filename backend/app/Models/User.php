<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Laravel\Sanctum\HasApiTokens;

use Database\Factories\UserFactory;

use App\Models\Enums\UserType;
use App\Models\Enums\Gender;
use App\Models\Classroom;


class User extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'email',
        'secondary_email',
        'password',
        'name',
        'type',
        'gender'
    ];

    protected $hidden = [
        'remember_token',
        'password',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'type'              => UserType::class,
            'gender'            => Gender::class
        ];
    }

    public function classes() : HasMany
    {
        return $this->hasMany( Classroom::class );
    }
}
