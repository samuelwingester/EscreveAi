<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Activity;
use App\Models\Classroom;

/**
 * @extends Factory<Activity>
 */
class ActivityFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition() : array
    {
        return [
            'title' => fake()->name(),
            'description' => fake()->text(200)
        ];
    }

    public function withClassroom() : static //mudar formato depois olhar userfactory
    {
        return $this->state(function (array $attributes) {
            return [
                'classroom_id' => Classroom::factory()->withTeacher()
            ];
        });
    }
}
