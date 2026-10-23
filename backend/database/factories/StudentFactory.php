<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Enums\WritingLevel;
use App\Models\Classroom;
use App\Models\Student;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition() : array
    {
        return [
            'writing_level' => fake()->randomElement( WritingLevel::class ),
            'observations'  => fake()->text() ? fake()->boolean( 75 ) : null,
            'name'          => fake()->name(),
            'birth_date'    => fake()->date()
        ];
    }

    public function withClassroom() : static
    {
        return $this->state( fn ( array $attributes ) => [
            'classroom_id' => Classroom::factory()->withTeacher()
        ]);
    }
}
