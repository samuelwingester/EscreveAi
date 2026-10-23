<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Enums\UserType;
use App\Models\Enums\Gender;
use App\Models\User;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition() : array
    {
        return [
            'email'     => fake()->unique()->safeEmail(),
            'password'  => Hash::make('password'),
            'name'      => fake()->name(),
            'type'      => UserType::TEACHER,
            'gender'    => fake()->randomElement(Gender::class)
        ];
    }

    public function verified() : static
    {
        return $this->state( fn ( array $attributes ) => [
            'email_verified_at' => now()
        ]);
    }

    public function withToken() : static
    {
        return $this->state( fn ( array $attributes ) => [
            'remember_token' => Str::random( 10 )
        ]);
    }

    public function teacher() : static
    {
        return $this->state( fn ( array $attributes ) => [
            'type' => UserType::TEACHER
        ]);
    }
}
