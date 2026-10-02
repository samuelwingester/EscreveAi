<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryInterface;

use App\Repositories\Repository;
use App\Models\User;

class UserRepository extends Repository implements UserRepositoryInterface
{
    protected string $modelClass = User::class;

    function getByEmail( int|string $email ) : ?object
    {
        return $this->modelClass::where( 'email', '=' , $email )->first();
    }
}
