<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Professor;

#[Table('turmas')]
class Turma extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'ativo',
        'criador_id'
    ];

    protected function casts(): array
    {
        return [
            'ativo' => 'boolean',
        ];
    }

    public function criador()
    {
        return $this->belongsTo(Professor::class, 'criador_id');
    }
}
