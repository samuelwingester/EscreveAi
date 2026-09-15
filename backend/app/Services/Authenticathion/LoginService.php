<?php

namespace App\Services\Authenticathion;

use Illuminate\Support\Facades\Hash;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Exceptions\InvalidCredentialsException;
use App\Models\User;

class LoginService
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {}

	public function verifyCredentials( string $email, string $password ): User
	{
		$user = $this->repository->getByEmail( $email );

		if ( !$user || !Hash::check( $password, $user->password ) )
			throw new InvalidCredentialsException();

		return $user;
	}
}
