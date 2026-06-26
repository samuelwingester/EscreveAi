<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Turma;

#[Table('professores')]
class Professor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'senha',
    ];

    public function turmas()
    {
        return $this->hasMany(Turma::class, 'turma_id');
    }
}
