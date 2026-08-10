<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\Authenticathion\LoginRequest;
use App\Http\Requests\Authenticathion\RegisterRequest;
use App\Http\Requests\Teacher\StoreTeacherRequest; // Temporario

use App\Services\Authenticathion\LoginService;
use App\Services\Teacher\StoreTeacherService;

class AuthController extends Controller
{
    public function login( LoginRequest $request, LoginService $service )
    {
        $user = $service->execute( $request->input( 'email' ), $request->input( 'password' ) ); 

        // Talvez mover a criação de token para um service proprio
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
        // RegisterRequest $request, 
        StoreTeacherRequest $request,
        StoreTeacherService $service   
    ){
        $user = $service->execute( $request->validated() );

        // NT: Talvez passar para um service depois.
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
