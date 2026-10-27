<?php

namespace App\Http\Controllers;

/**
 * TO DO:
 * - Adicionar rota de deletar usuario
 */

use Illuminate\Http\Response;
use Illuminate\Http\Request;

use App\Http\Requests\Authentication\ChangePasswordRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\UpdateRequest;
use App\Http\Resources\UserResource;

use App\Services\Authentication\ChangePasswordService;
use App\Services\Authentication\RegisterService;
use App\Services\Authentication\UpdateService;
use App\Services\Authentication\LoginService;
use App\Services\Authentication\TokenService;
use App\Services\Authentication\DeleteService;

use App\Models\User;

class AuthController extends Controller
{
    public function __construct(
        private ChangePasswordService $change_password,
        private RegisterService $register,
        private DeleteService $delete,
        private LoginService $login,
        private UpdateService $update,
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
        return new UserResource( $request->user() );
    }

    public function update( UpdateRequest $request ) : UserResource
    {
        $user = $this->update->execute( $request->user(), $request->validated() );

        return new UserResource( $user );
    }

    public function delete( Request $request ) : Response
    {
        $this->delete->execute( $request->user() );

        return response()->noContent();
    }

    public function change_password( ChangePasswordRequest $request ) : Response
    {
        $data = $request->validated();

        $this->change_password->execute( $request->user(), $data['password'], $data['new_password'] );

        return response()->noContent();
    }

    private function tokenResponse( User $user, string $agent ) : UserResource
    {
        $token = $this->token->create( $user, $agent );

        return new UserResource( $user )->additional( [ 'token' => $token ] );
    }
}
