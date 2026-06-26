<?php

namespace Database\Factories;

use App\Models\Turma;
use App\Models\Professor;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Turma>
 */
class TurmaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => fake()->domainName(),
            'ativo' => fake()->boolean(),
            'criador_id' => Professor::factory()
        ];
    }
}
