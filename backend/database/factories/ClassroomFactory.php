<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Classroom;
# use App\Models\Teacher;
use App\Models\User;
use App\Enums\Shift;

/**
 * @extends Factory<Classroom>
 */
class ClassroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'      => fake()->randomLetter(),
            'active'    => fake()->boolean(95),
            'shift'     => fake()->randomElement( Shift::class )
        ];
    }

    public function withTeacher(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                /*
                'teacher_id' => Teacher::factory()
                */
                'teacher_id' => User::factory()
            ];
        });
    }
}
