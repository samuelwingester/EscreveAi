<?php

namespace Database\Factories;

use App\Models\Professor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Professor>
 */
class ProfessorFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'email' =>fake()->unique()->safeEmail(),
            'senha' => static::$password ??= Hash::make('password')
        ];
    }
}
