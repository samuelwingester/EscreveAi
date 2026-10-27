<?php

namespace App\Services\Authentication;

use App\Models\User;

class UpdateService
{
	public function execute( User $user, array $data ) : User
	{
        $user->update( $data );

        return $user->refresh();
	}
}
