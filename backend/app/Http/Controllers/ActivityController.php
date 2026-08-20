<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Activity;

use App\Http\Requests\Activity\StoreActivityRequest as StoreRequest;
use App\Http\Requests\Activity\UpdateActivityRequest as UpdateRequest;

use App\Services\Activity\StoreActivityService as StoreService;
use App\Services\Activity\UpdateActivityService as UpdateService;

class ActivityController extends Controller
{
    public function __construct(
        protected StoreService $storeService,
        protected UpdateService $updateService
    ) { }
    public function index()
    {
        $activities = Activity::all();

        return response()->json( $activities, 200 );
    }

    public function store( StoreRequest $request )
    { 
        $activity = $this->storeService->execute( $request->validated() ); 

        return response()->json( $activity, 201 );
    }

    public function show( Activity $activity )
    {
        return response()->json( $activity, 200 );
    }

    public function update( UpdateRequest $request, Activity $activity )
    {
        $this->updateService->execute( $activity, $request->validated() );

        return response()->noContent( 204 );
    }

    public function destroy( Activity $activity )
    {
        $activity->deleteOrFail();

        return response()->noContent( 204 );
    }
}
