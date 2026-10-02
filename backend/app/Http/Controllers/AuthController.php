<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

use App\Http\Requests\Authenticathion\RegisterRequest;
use App\Http\Requests\Authenticathion\LoginRequest;
use App\Http\Resources\UserResource;

use App\Services\Authenticathion\RegisterService;
use App\Services\Authenticathion\LoginService;
use App\Services\Authenticathion\TokenService;

use App\Models\User;

class AuthController extends Controller
{
    public function __construct(
        private LoginService $login,
        private RegisterService $register,
        private TokenService $token
    ){}

    public function login( LoginRequest $request ) : UserResource
    {
        $data = $request->validated();

        $user = $this->login->verifyCredentials( $data['email'], $data['password'] );

        return $this->tokenResponse( $user, $request->header( 'User-Agent' ) );
    }

    public function register( RegisterRequest $request ) : UserResource
    {
        $user = $this->register->store( $request->validated() );

        return $this->tokenResponse( $user, $request->header( 'User-Agent' ) );
    }

    public function logout( Request $request ) : Response
    {
        $this->token->deleteCurrentToken( $request->user() );

        return response()->noContent();
    }

    public function user( Request $request ) : UserResource
    {
        return ( new UserResource( $request->user() ) );
    }

    private function tokenResponse( User $user, string $agent ) : UserResource
    {
        $token = $this->token->create( $user, $agent );

        return ( new UserResource( $user ) )->additional( [ 'token' => $token ] );
    }
}
