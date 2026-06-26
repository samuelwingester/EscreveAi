<?php

namespace Database\Factories;

use App\Models\Aluno;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Responsavel;

/**
 * @extends Factory<Aluno>
 */
class AlunoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'responsavel_id' => Responsavel::factory(),
            'data_nascimento' => fake()->dateTimeBetween('-80 years', 'now')->format('Y-m-d') 
        ];
    }
}
