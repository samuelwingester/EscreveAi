<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\User;
use App\Models\Classroom;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    protected $fillable = [
        'user_id'
    ];

    //--------------------------------------------------------
    // Relacionamentos
    //--------------------------------------------------------
    public function user(): BelongsTo
    {
        return $this->belongsTo( User::class, 'user_id' );
    }
    
    public function classes(): HasMany
    {
        return $this->hasMany( Classroom::class );
    }
    //--------------------------------------------------------

    //--------------------------------------------------------
    // Acessors
    //--------------------------------------------------------
    protected function name(): Attribute
    {
        return Attribute::make(
            get : fn() => $this->user->name
        );
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            get : fn() => $this->user->email
        );
    }

    protected function birthDate(): Attribute
    {
        return Attribute::make(
            get : fn() => $this->user->birth_date
        );
    }

    public function gender(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->user->gender
        );
    }

    protected function secondaryEmail(): Attribute
    {
        return Attribute::make(
            get : fn() => $this->user->secondary_email
        );
    }
    //--------------------------------------------------------
}
