<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Student;

use App\Http\Requests\Student\StoreStudentRequest as StoreRequest;
use App\Http\Requests\Student\UpdateStudentRequest as UpdateRequest;

use App\Services\Student\StoreStudentService as StoreService;
use App\Services\Student\UpdateStudentService as UpdateService;
use App\Services\Student\DataStudentService as DataService;

use App\Models\Classroom;

class StudentController extends Controller
{
    public function __construct(
        protected StoreService $storeService,
        protected UpdateService $updateService,
        protected DataService $dataService,
    ) {}

    public function index( Classroom $classroom )
    {
        $this->authorize( 'view', $classroom );

        $students = $this->dataService->getByClassroom( $classroom->id );

        return response()->json( $students, 200 );
    }

    public function store( Classroom $classroom, StoreRequest $request ){
        $this->authorize( 'update', $classroom ); // Acho que essa e a autorização certa se não for mudo depois

        $data = $request->validated();
        $data['class_id'] = $classroom->id;

        $student = $this->storeService->execute( $data );

        return response()->json( $student, 201 );
    }

    public function show( Classroom $classroom, Student $student )
    {
        return response()->json( $student, 200 );
    }

    public function update( UpdateRequest $request, Classroom $classroom , Student $student ){
        $this->updateService->execute( $request->validated(), $student );

        return response()->noContent( 204 );
    }

    public function destroy( Classroom $classroom, Student $student )
    {
        $this->authorize( 'update', $classroom );

        $student->deleteOrFail();

        return response()->noContent( 204 );
    }
}
