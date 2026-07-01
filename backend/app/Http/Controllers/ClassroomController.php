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

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->deleteOrFail();

        return response()->noContent();
    }
}
