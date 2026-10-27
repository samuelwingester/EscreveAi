<?php

namespace App\Http\Controllers;

/**
 * TO DO
 * - Criar um controller de Anexos para visualização e remoção
 * - adicionar carregamento de relacionamento condicional no ListService
 */
use App\Http\Resources\Activity\ActivityCollection;
use App\Http\Resources\Activity\ActivityResource;

use App\Http\Requests\Activity\StoreRequest;
use App\Http\Requests\Activity\UpdateRequest;
use App\Http\Requests\Activity\ListRequest;

use App\Http\Controllers\Controller;

use App\Services\Activity\StoreService;
use App\Services\Activity\UpdateService;
use App\Services\Activity\ListService;
use App\Services\Activity\DeleteService;

use App\Models\Activity;
use App\Models\Classroom;

class ActivityController extends Controller
{
    public function __construct(
        protected StoreService $store,
        protected UpdateService $update,
        protected ListService $list,
        protected DeleteService $delete
    ) { }

    public function index( ListRequest $request, Classroom $classroom ) : ActivityCollection
    {
        $this->authorize( 'view', $classroom );

        $options = $request->getQueryOptions();

        $columns = $request->safe()->only('fields')['fields'];

        $data = $this->list->execute( $classroom->id, $options, $columns );

        return new ActivityCollection( $data['data'], $data['total'], $data['count'], $options );
    }

    public function store( StoreRequest $request, Classroom $classroom ) : ActivityResource
    {
        $this->authorize( 'update', $classroom );

        $activity = $this->store->execute( $request->user(), $classroom, $request->validated() );

        return new ActivityResource( $activity->load( 'attachments' ) );
    }

    public function show( Classroom $classroom, Activity $activity )
    {
        $this->authorize( 'view', $classroom );

        return new ActivityResource( $activity->load( 'attachments' ) );
    }

    public function update( UpdateRequest $request, Classroom $classroom, Activity $activity )
    {
        $this->authorize( 'update', $classroom );

        $activity = $this->update->execute( $request->user(), $activity, $request->validated() );

        return new ActivityResource( $activity->load( 'attachments' ) );
    }

    public function destroy( Classroom $classroom, Activity $activity )
    {
        $this->authorize( 'update', $classroom );

        $this->delete->execute( $activity );

        return response()->noContent( 204 );
    }
}
