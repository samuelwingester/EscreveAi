<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Student;
use App\Models\User;
use App\Models\Classroom;

use App\Enums\WritingLevel;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'       => User::factory()->student(),
            'writing_level' => fake()->randomElement( WritingLevel::class ),
            'observations'  => fake()->text(),
        ];
    }
}
