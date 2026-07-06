<?php

namespace App\Http\Controllers\Web\Student;

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
        $students = Student::all();

        return view( 'view::students;index', $students );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view( 'view::students.create' );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( StoreStudentRequest $request, StoreStudentService $service )
    {
        $service->execute( $request->validated() );

        return redirect()->route( 'view::students.index' )
                         ->with( 'success', 'Aluno criado com sucesso' );
    }

    /**
     * Display the specified resource.
     */
    public function show( Student $student )
    {
        return view( 'view::students.show', $student );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Student $student )
    {
        return view( 'view::students.edit', $student );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( UpdateStudentRequest $request, UpdateStudentService $service , Student $student )
    {
        $service->execute( $request->validated(), $student );

        return redirect()->route( 'view::students.index' )
                         ->with( 'success', 'Aluno atualizado com sucesso' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Student $student )
    {
        $student->deleteOrFail();

        return redirect()->route( 'view::students.index' )
                         ->with( 'success', 'Aluno deletado com sucesso' );
    }
}
