<?php

namespace App\Services\Authentication;

use Illuminate\Support\Facades\Hash;

use App\Exceptions\InvalidCredentialsException;
use App\Models\User;

class ChangePasswordService
{
	public function execute( User $user, string $password, string $new_password ) : bool
	{
		if ( !$user || !Hash::check( $password, $user->password ) )
			throw new InvalidCredentialsException();

        $user->password = Hash::make( $new_password );

        return $user->save();
	}
}
