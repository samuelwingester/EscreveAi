<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Classroom;
use App\Models\Teacher;

use Illuminate\Http\Request;
use App\Http\Requests\Classroom\StoreClassroomRequest as StoreRequest;
use App\Http\Requests\Classroom\UpdateClassroomRequest as UpdateRequest;

use App\Services\Classroom\StoreClassroomService as StoreService;
use App\Services\Classroom\UpdateClassroomService as UpdateService;
use App\Services\Classroom\DataClassroomService as DataService;

class ClassroomController extends Controller
{
    public function __construct(
        protected StoreService $storeService,
        protected UpdateService $updateService,
        protected DataService $dataService
    ) {}

    public function index( Request $request )
    {
        $classrooms = $this->dataService->list( $request->user() );

        return response()->json( $classrooms, 200 );
    }

    public function store( StoreRequest $request ){
        $classroom = $this->storeService->execute( $request->user, $request->validated( 'name' ) );

        return response()->json( $classroom, 201 );
    }

    public function show( Classroom $classroom )
    {
        $this->authorize( 'view', $classroom );

        return response()->json( $classroom, 200 );
    }

    public function update( UpdateRequest $request, Classroom $classroom )
    {
        $this->authorize( 'update', $classroom );

        $this->updateService->execute( $classroom, $request->validated() );

        return response()->noContent( 204 );
    }

    public function destroy( Classroom $classroom )
    {
        $this->authorize( 'delete', $classroom );

        $classroom->deleteOrFail();

        return response()->noContent( 204 );
    }

    public function stats( Classroom $classroom )
    {
        $this->authorize( 'view', $classroom );

        $data = $this->dataService->generateStats( $classroom );

        return response()->json([
        'name' => $classroom->name,
        'id' => $classroom->id,

        'status' => [
            'pre-silabico'        => $data->pre_silabico,
            'silabico'            => $data->silabico,
            'silabico-alfabetico' => $data->silabico_alfabetico,
            'alfabetico'          => $data->alfabetico,
        ],

        'total' => [
            'students'   => $data->students,
            'activities' => $data->activities,
            'reports'    => $data->reports,
        ],
    ], 200);
    }
}
