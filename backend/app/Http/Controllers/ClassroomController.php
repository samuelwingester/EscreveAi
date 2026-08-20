<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Classroom;
use App\Models\Teacher;

use App\Http\Requests\Classroom\StoreClassroomRequest as StoreRequest;
use App\Http\Requests\Classroom\UpdateClassroomRequest as UpdateRequest;

use App\Services\Classroom\StoreClassroomService as StoreService;
use App\Services\Classroom\UpdateClassroomService as UpdateService;

class ClassroomController extends Controller
{
    public function __construct(
        protected StoreService $storeService,
        protected UpdateService $updateService
    ) {}

    public function index()
    {
        $classrooms = Classroom::all();

        return response()->json( $classrooms, 200 );
    }

    public function store( StoreRequest $request ){
        $classroom = $this->storeService->execute( $request->user, $request->validated( 'name' ) );
        
        return response()->json( $classroom, 201 );
    }

    public function show( Classroom $classroom )
    {
        return response()->json( $classroom, 200 );
    }

    public function update( UpdateRequest $request, Classroom $classroom )
    { 
        $this->updateService->execute( $classroom, $request->validated() );

        return response()->noContent( 204 );
    }

    public function destroy( Classroom $classroom )
    {
        $classroom->deleteOrFail();

        return response()->noContent( 204 );
    }
}
