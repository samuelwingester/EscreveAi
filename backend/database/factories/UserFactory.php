<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use App\Enums\UserType;
use App\Enums\Gender;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' 		=> fake()->unique()->email(),
            'password' 		=> Hash::make( fake()->password(5, 25) ),
            'name' 			=> fake()->name(),
            'gender' 		=> fake()->randomElement( Gender::class ),
            'birth_date' 	=> fake()->date()
        ];
    }

    public function student(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => UserType::STUDENT
            ];
        });
    }

    public function teacher(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => UserType::TEACHER
            ];
        });
    }
}
