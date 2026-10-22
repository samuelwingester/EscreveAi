<?php

namespace App\Services\Authenticathion;

use Illuminate\Support\Facades\Hash;

use App\Models\Enums\UserType;
use App\Models\User;

class RegisterService
{
	public function store( array $data ) : User
	{
        return User::create([
            'email' 		=> $data['email'],
            'password' 		=> Hash::make( $data['password'] ),
            'name' 			=> $data['name'],
            'gender' 		=> $data['gender'] ?? null,
            'type'			=> UserType::TEACHER
        ]);
	}
}
