<?php

namespace App\Http\Controllers\Web;

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
        $classroom = Classroom::all();

        return view( 'view::classroom.index', compact( 'classroom' ) );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view( 'view::classroom.index' );
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
        
        return redirect()->route( 'classroom.index' )
                         ->with( 'success', 'turma criada com sucesso' );
    }

    /**
     * Display the specified resource.
     */
    public function show( Classroom $classroom )
    {
        return view( 'view::classroom.show', compact( 'classroom' ) );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Classroom $classroom )
    {
        return view( 'view::classroom.edit', compact( 'classroom' ) );
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

        return redirect()->route( 'classroom.index' )
                         ->with( 'success', 'Turma atualizada com sucesso' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Classroom $classroom )
    {
        $classroom->deleteOrFail();

        return redirect()->route( 'classroom.index' )
                         ->with( 'success', 'Turma deletado com sucesso' );
    }
}
