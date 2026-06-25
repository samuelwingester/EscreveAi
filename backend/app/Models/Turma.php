<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Table('turmas', key:'turma_id')]
class Turma extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'status'
    ];
}
#UseFactory(TurmaFactory::class)