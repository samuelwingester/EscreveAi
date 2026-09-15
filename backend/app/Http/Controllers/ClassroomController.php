<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Resources\Classroom\ClassroomStatsResource;
use App\Http\Resources\Classroom\ClassroomCollection;
use App\Http\Resources\Classroom\ClassroomResource;
use App\Http\Requests\Classroom\StoreRequest;
use App\Http\Requests\Classroom\UpdateRequest;
use App\Http\Requests\Classroom\ListRequest;
use App\Http\Controllers\Controller;

use App\Services\Classroom\StoreService;
use App\Services\Classroom\UpdateService;
use App\Services\Classroom\DataService;

use App\Models\Classroom;

class ClassroomController extends Controller
{
    public function __construct(
        protected StoreService $store,
        protected UpdateService $update,
        protected DataService $data
    ) {}

    public function index( ListRequest $request ) : ClassroomCollection
    {
        $options = $request->validated();

        $columns = $options['columns'];

        unset( $options['columns'] ); // Não e necessario, mas e bom fazer isso;

        $data = $this->data->list( $request->user(), $options, $columns );

        return new ClassroomCollection( $data['data'], $data['total'], $data['count'], $options['limit'], $options['offset'] );
    }

    public function store( StoreRequest $request ) : ClassroomResource
    {
        $classroom = $this->store->execute( $request->user(), $request->validated() );

        return new ClassroomResource( $classroom );
    }

    public function show( Request $request, Classroom $classroom ) : ClassroomResource
    {
        $this->authorize( 'view', $classroom );

        return new ClassroomResource( $classroom );
    }

    public function update( UpdateRequest $request, Classroom $classroom ) : ClassroomResource
    {
        $this->authorize( 'update', $classroom );

        $this->update->execute( $classroom, $request->validated() );

        return new ClassroomResource( $classroom );
    }

    public function destroy( Classroom $classroom ) : Response
    {
        $this->authorize( 'delete', $classroom );

        $classroom->deleteOrFail(); // Mudar depois.

        return response()->noContent( 204 );
    }

    public function stats( Classroom $classroom ) : ClassroomStatsResource
    {
        $this->authorize( 'view', $classroom );

        $data = $this->data->generateStats( $classroom );

        return new ClassroomStatsResource( $classroom, $data );
    }
}
