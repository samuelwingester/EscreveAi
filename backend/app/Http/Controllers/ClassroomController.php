<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Classroom;
use App\Models\Teacher;

use App\Http\Requests\Classroom\StoreClassroomRequest;
use App\Http\Requests\Classroom\UpdateClassroomRequest;

use App\Services\Classroom\StoreClassroomService;
use App\Services\Classroom\UpdateClassroomService;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = Classroom::all();

        return response()->json( $classrooms, 200 );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( 
        StoreClassroomRequest $request, 
        StoreClassroomService $service 
    ){
        $teacher = Teacher::find( $request->validated( 'teacher_id' ), 'id' ); 
        // Provavelmente desnecessario mudar futuramente. recurso dependente de outro

        $service->execute( $teacher, $request->validated( 'name' ) );
        
        return response()->noContent( 201 );
    }

    /**
     * Display the specified resource.
     */
    public function show( Classroom $classroom )
    {
        return response()->json( $classroom, 200 );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( 
        UpdateClassroomRequest $request, 
        UpdateclassroomService $service, 
        Classroom $classroom 
    ){
        $service->execute( $classroom, $request->validated() );

        return response()->noContent( 204 );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Classroom $classroom )
    {
        $classroom->deleteOrFail();

        return response()->noContent( 204 );
    }
}
