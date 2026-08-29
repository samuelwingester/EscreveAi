<?php

namespace App\Http\Controllers;

use App\Models\Record;

use App\Http\Requests\Record\StoreRecordRequest as StoreRequest;
use App\Http\Requests\Record\UpdateRecordRequest as UpdateRequest;

use App\Service\Record\StoreRecordService as StoreService;
use App\Service\Record\UpdateRecordService as UpdateService;

class RecordController extends Controller
{
    public function __construct(
        private StoreService $storeService,
        private UpdateService $updateService
    ) {}

    public function index()
    {
        $records = Record::all();

        return response()->json( $records, 200 );
    }

    public function store( StoreRequest $request )
    {
        $record = $this->storeService->execute( $request->validated() );

        return response()->json( $record, 201 );
    }

    public function show( Record $record )
    {
        return response()->json( $record, 200 );
    }

    public function update( UpdateRequest $request, Record $record )
    {
        $this->updateService->execute( $record, $request->validated() );

        return response()->noContent( 204 );
    }

    public function destroy( Record $record )
    {
        $record->deleteOrFail();

        return response()->noContent( 204 );
    }
}
