<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    //--------------------------------------------------------
    // Relacionamentos
    //--------------------------------------------------------
    public function user(): BelongsTo
    {
        return $this->belongsTo( User::class, 'user_id' );
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo( Classroom::class, 'class_id' );
    }

    public function records(): HasMany
    {
        return $this->hasMany( Record::class );
    }

    public function reports(): HasMany
    {
        return $this->hasMany( Report::class );
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
