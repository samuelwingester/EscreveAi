<?php

namespace App\Http\Controllers;

/**
 * TO DO:
 * - Adicionar rota de sumario -> calcular estatisticas como numero de estudantes,
 *   atividades, etc. para todas as turmas de um usuario.
 */

use Illuminate\Http\Response;

use App\Http\Resources\Classroom\ClassroomStatsResource;
use App\Http\Resources\Classroom\ClassroomCollection;
use App\Http\Resources\Classroom\ClassroomResource;

use App\Http\Requests\Classroom\StoreRequest;
use App\Http\Requests\Classroom\UpdateRequest;
use App\Http\Requests\Classroom\ListRequest;

use App\Http\Controllers\Controller;

use App\Services\Classroom\GenerateStatsService;
use App\Services\Classroom\StoreService;
use App\Services\Classroom\UpdateService;
use App\Services\Classroom\DeleteService;
use App\Services\Classroom\ListService;

use App\Models\Classroom;

class ClassroomController extends Controller
{
    public function __construct(
        protected StoreService $store,
        protected UpdateService $update,
        protected DeleteService $delete,
        protected ListService $list,
        protected GenerateStatsService $stats,
    ) {}

    public function index( ListRequest $request ) : ClassroomCollection
    {
        $options = $request->getQueryOptions();

        $columns = $request->safe()->only('fields')['fields'];

        $data = $this->list->execute( $request->user()->id, $options, $columns );

        return new ClassroomCollection( $data['data'], $data['total'], $data['count'], $options );
    }

    public function store( StoreRequest $request ) : ClassroomResource
    {
        $classroom = $this->store->execute( $request->user(), $request->validated() );

        return new ClassroomResource( $classroom );
    }

    public function show( Classroom $classroom ) : ClassroomResource
    {
        $this->authorize( 'view', $classroom );

        return new ClassroomResource( $classroom );
    }

    public function update( UpdateRequest $request, Classroom $classroom ) : ClassroomResource
    {
        $this->authorize( 'update', $classroom );

        $classroom = $this->update->execute( $classroom, $request->validated() );

        return new ClassroomResource( $classroom );
    }

    public function destroy( Classroom $classroom ) : Response
    {
        $this->authorize( 'delete', $classroom );

        $this->delete->execute( $classroom );

        return response()->noContent( 204 );
    }

    public function stats( Classroom $classroom ) : ClassroomStatsResource
    {
        $this->authorize( 'view', $classroom );

        $data = $this->stats->generate( $classroom->id );

        return new ClassroomStatsResource( $classroom, $data );
    }
}
