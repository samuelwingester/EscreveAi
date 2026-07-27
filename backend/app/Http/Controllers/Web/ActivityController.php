<?php

namespace App\Http\Controllers\Web;

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

        return view( 'view::activity.index', compact( 'activities' ) );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view( 'view::activity.create' );
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

        return redirect()->route( 'activity.index' )
                         ->with( 'success', 'atividade criada com sucesso' );
    }

    /**
     * Display the specified resource.
     */
    public function show( Activity $activity )
    {
        return view( 'view::activity.show', compact( 'activity' ) );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Activity $activity )
    {
        return view( 'view::activity.edit', compact( 'activity' ) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Activity $activity )
    {
        $activity->deleteOrFail();

        return redirect()->route( 'activity.index' )
                         ->with( 'success', 'Atividade deletada com sucesso' );
    }
}
