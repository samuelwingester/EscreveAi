<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Student;

use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;

use App\Services\Student\StoreStudentService;
use App\Services\Student\UpdateStudentService;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with( 'user' )->get();

        return response()->json( $students, 200 );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( 
        StoreStudentRequest $request, 
        StoreStudentService $service 
    ){
        $service->execute( $request->validated() );

        return response()->noContent( 201 );
    }

    /**
     * Display the specified resource.
     */
    public function show( Student $student )
    {
        // Carrega os dados relacionados a usuario
        $student->load( 'user' );

        return response()->json( $student, 200 );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( 
        UpdateStudentRequest $request, 
        UpdateStudentService $service, 
        Student $student 
    ){
        $service->execute( $request->validated(), $student );

        return response()->noContent( 204 );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Student $student )
    {
        $student->user->deleteOrFail();

        return response()->noContent( 204 );
    }
}
