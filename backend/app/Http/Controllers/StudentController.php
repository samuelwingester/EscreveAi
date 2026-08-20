<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Student;

use App\Http\Requests\Student\StoreStudentRequest as StoreRequest;
use App\Http\Requests\Student\UpdateStudentRequest as UpdateRequest;

use App\Services\Student\StoreStudentService as StoreService;
use App\Services\Student\UpdateStudentService as UpdateService;

class StudentController extends Controller
{
    public function __construct(
        protected StoreService $storeService,
        protected UpdateService $updateService
    ) {}

    public function index()
    {
        $students = Student::all();

        return response()->json( $students, 200 );
    }

    public function store( StoreRequest $request ){
        $student = $this->storeService->execute( $request->validated() );

        return response()->json( $student, 201 );
    }

    public function show( Student $student )
    {
        return response()->json( $student, 200 );
    }

    public function update( UpdateRequest $request, Student $student ){
        $this->updateService->execute( $request->validated(), $student );

        return response()->noContent( 204 );
    }

    public function destroy( Student $student )
    {
        $student->deleteOrFail();

        return response()->noContent( 204 );
    }
}
