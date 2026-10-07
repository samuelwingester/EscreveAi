<?php

namespace App\Services\Authenticathion;

use Laravel\Sanctum\PersonalAccessToken;

use App\Models\User;

class TokenService
{
	public function create( User $user, string|null $name = null ) : string
	{
        if ( !$name ) $name = 'unknown';

        return $user->createToken( $name )->plainTextToken;
	}

    public function deleteCurrentToken( User $user )
    {
        $user->currentAccessToken()->delete();
    }
}
