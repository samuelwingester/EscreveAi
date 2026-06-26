<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Aluno;

#[Table('responsaveis')]
class Responsavel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'senha',
    ];

    public function filhos()
    {
        return $this->hasMany(Aluno::class, 'aluno_id');
    }
}
