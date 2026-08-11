<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Classroom;

/**
 * @extends Factory<Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'description' => fake()->text(200)
        ];
    }

    public function withClassroom(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'class_id' => Classroom::factory()->withTeacher()
            ];
        });
    }
}
