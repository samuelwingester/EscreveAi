<?php

namespace App\Services\Authenticathion;

use Illuminate\Support\Facades\Hash;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\Enums\UserType;
use App\Models\User;

class RegisterService
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {}

	public function store( array $data ) : User
	{
        return $this->repository->create([
            'email' 		=> $data['email'],
            'password' 		=> Hash::make( $data['password'] ),
            'name' 			=> $data['name'],
            'gender' 		=> $data['gender'] ?? null,
            'type'			=> UserType::TEACHER
        ]);
	}
}
