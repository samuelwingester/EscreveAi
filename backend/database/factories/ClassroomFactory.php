<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Enums\Shift;
use App\Models\Classroom;
use App\Models\User;

/**
 * @extends Factory<Classroom>
 */
class ClassroomFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition() : array
    {
        return [
            'name'      => fake()->randomLetter(),
            'school'    => fake()->domainName(),
            'shift'     => fake()->randomElement( Shift::class ),
            'active'    => fake()->boolean(),
        ];
    }

    public function withTeacher() : static
    {
        return $this->state( fn ( array $attributes ) => [
            'teacher_id' => User::factory()
        ]);
    }
}
