<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\Authenticathion\LoginRequest;
use App\Http\Requests\Authenticathion\RegisterRequest;


use App\Services\Authenticathion\LoginService;
use App\Services\Teacher\StoreTeacherService;

use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login( LoginRequest $request, LoginService $service )
    {
        $user = $service->execute( $request->input( 'email' ), $request->input( 'password' ) ); 

        $token = $user->createToken( $request->header( 'User-Agent' ) ?? 'unknown' );

        return response()->json([
            'token' => $token->plainTextToken,
            'user'  => [
                'name'  => $user->name,
                'id'    => $user->id
            ]
        ], 200);
    }

    public function register( 
        RegisterRequest $request, 
        StoreTeacherService $service   
    ){
        $user = $service->execute( $request->validated() )->user;

        $token = $user->createToken( $request->header( 'User-Agent' ) ?? 'unknown' );

        return response()->json([
            'token' => $token->plainTextToken,
            'user'  => [
                'name'  => $user->name,
                'id'    => $user->id
            ]
        ], 201);
    }

    public function logout( Request $request )
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent( 204 );
    }

    public function user( Request $request )
    {
        return response()->json( $request->user(), 200 );
    }
}
