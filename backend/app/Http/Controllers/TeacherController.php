<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Teacher;

use App\Http\Requests\Teacher\StoreTeacherRequest;
use App\Http\Requests\Teacher\UpdateTeacherRequest;

use App\Services\Teacher\StoreTeacherService;
use App\Services\Teacher\UpdateTeacherService;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with( 'user' )->get();

        return response()->json( $teachers, 200 );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreTeacherRequest $request, 
        StoreTeacherService $service
    ){
        $service->execute( $request->validated() );

        return response()->noContent( 201 );
    }

    /**
     * Display the specified resource.
     */
    public function show( Teacher $teacher )
    {
        // Carrega os dados relacionados a usuario
        $teacher->load( 'user' );

        return response()->json( $teacher, 200 );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( 
        UpdateTeacherRequest $request, 
        UpdateTeacherService $service, 
        Teacher $teacher
    ){
        $service->execute( $request->validated(), $teacher );

        return response()->noContent( 204 );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Teacher $teacher )
    {
        $teacher->user->deleteOrFail();

        return response()->noContent( 204 );
    }
}
