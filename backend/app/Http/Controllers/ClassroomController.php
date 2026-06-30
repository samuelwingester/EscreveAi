<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Classroom;

use App\Services\Classroom\StoreClassroomService;
use App\Services\Classroom\UpdateClassroomService;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Classroom::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([ 
            'name' => ['required', 'max:100'],
            'teacher_id' => ['required', 'exists:professores,id']
        ]);

        return StoreClassroomService::execute( $data );      
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        return $classroom;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'max:100'],
            'active' => ['sometimes', 'boolean:strict']
        ]);

        return UpdateClassroomService::execute( $classroom, $data );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->deleteOrFail();

        //Retorna 204 se não houver erros
        return response()->noContent();
    }
}
