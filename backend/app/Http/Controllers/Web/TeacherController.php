<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Teacher;

use App\Http\Requests\Teacher\StoreTeacherRequest;
use App\Http\Requests\Teacher\UpdateTeacherRequest;

use App\Services\Teacher\StoreTeacherService;
use App\Services\Teacher\UpdateTeacherService;

//Temp
use Illuminate\Support\Facades\Log;
//

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with( 'user' )->get();

        return view( 'view::teacher.index', compact( 'teachers' ) );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view( 'view::teacher.create' );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherRequest $request, StoreTeacherService $service)
    {
        $service->execute( $request->validated() );

        return redirect()->route( 'view::teacher.index' )
                         ->with( 'success', 'Professor criado com sucesso' );
    }

    /**
     * Display the specified resource.
     */
    public function show( Teacher $teacher )
    {
        // Carrega os dados relacionados a usuario
        $teacher->load( 'user' );

        return view( 'view::teacher.show', compact( 'teacher' ) );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Teacher $teacher )
    {
        // Carrega os dados relacionados a usuario
        $teacher->load( 'user' );

        return view( 'view::teacher.edit', compact( 'teacher' ) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( UpdateTeacherRequest $request, UpdateTeacherService $service, Teacher $teacher )
    {
        $service->execute( $request->validated(), $teacher );

        return redirect()->route( 'view::teacher.index' )
                         ->with( 'success', 'Professor atualizado com sucesso' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Teacher $teacher )
    {
        $teacher->user()->deleteOrFail();

        return redirect()->route( 'view::teacher.index' )
                         ->with( 'success', 'Professor deletado com sucesso' );
    }
}
