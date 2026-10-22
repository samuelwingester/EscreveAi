<?php

namespace App\Services\Authenticathion;

use Illuminate\Support\Facades\Hash;

use App\Exceptions\InvalidCredentialsException;
use App\Models\User;

class LoginService
{
	public function verifyCredentials( string $email, string $password ): User
	{
        $user = User::where( 'email', $email )->first();

		if ( !$user || !Hash::check( $password, $user->password ) )
			throw new InvalidCredentialsException();

		return $user;
	}
}
