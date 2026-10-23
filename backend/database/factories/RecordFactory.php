<?php

namespace Database\Factories;

use App\Models\Record;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Student;
use App\Models\Activity;

/**
 * @extends Factory<Record>
 */
class RecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [ ];
    }

    public function withStudent(): Factory
    {
        return $this->state(function (array $attributes) {
            return [ 'student_id' => Student::factory()->withClassroom() ];
        });
    }

    public function withActivity(): Factory
    {
        return $this->state(function (array $attributes) {
            return [ 'activity_id' => Activity::factory()->withClassroom() ];
        });
    }
}
