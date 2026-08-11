<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Activity;
use App\Models\Classroom;

use App\Http\Requests\Activity\StoreActivityRequest;

use App\Services\Attachment\AttachmentsHandlerService;
use App\Services\Activity\StoreActivityService;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = Activity::all();

        return response()->json( $activities, 200 );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( 
        StoreActivityRequest $request, 
        StoreActivityService $service, 
        AttachmentsHandlerService $attachmentHandler 
    ){ 
        $classroom = Classroom::find( $request->validated( 'class_id' ), 'id' );

        $activity = $service->execute( $classroom, $request->safe()->except(['attachments']));

        // NT: Talvez seja interessante criar uma exceção personalizada se algum anexo
        // falhar. e lidar de forma diferente, pensar melhor depois.
        // - Talvez fazer o servico retornar algo e passar para a resposta?
        $attachmentHandler->execute( $activity, $request->validated('attachments') );

        return response()->noContent( 201 );
    }

    /**
     * Display the specified resource.
     */
    public function show( Activity $activity )
    {
        return response()->json( $activity, 200 );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        // 204
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Activity $activity )
    {
        $activity->deleteOrFail();

        return response()->noContent( 204 );
    }
}
