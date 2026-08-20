<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Teacher;

use App\Http\Requests\Teacher\StoreTeacherRequest as StoreRequest;
use App\Http\Requests\Teacher\UpdateTeacherRequest as UpdateRequest;

use App\Services\Teacher\StoreTeacherService as StoreService;
use App\Services\Teacher\UpdateTeacherService as UpdateService;

class TeacherController extends Controller
{
    public function __construct(
        protected StoreService $storeService,
        protected UpdateService $updateService
    ){}
    
    public function index()
    {
        $teachers = Teacher::with( 'user' )->get();

        return response()->json( $teachers, 200 );
    }

    public function store( StoreRequest $request ){
        $teacher = $this->storeService->execute( $request->validated() );

        return response()->json( $teacher, 201 );
    }

    public function show( Teacher $teacher  )
    {
        return response()->json( $teacher, 200 );
    }

    public function update( UpdateRequest $request, Teacher $teacher ){
        $this->updateService->execute( $teacher, $request->validated() );

        return response()->noContent( 204 );
    }
    
    public function destroy( Teacher $teacher )
    {
        $teacher->deleteOrFail();

        return response()->noContent( 204 );
    }
}
