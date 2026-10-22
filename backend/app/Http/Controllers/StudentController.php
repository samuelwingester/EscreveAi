<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

use App\Http\Resources\Student\StudentCollection;
use App\Http\Resources\Student\StudentResource;

use App\Http\Requests\Student\UpdateRequest;
use App\Http\Requests\Student\StoreRequest;
use App\Http\Requests\Student\ListRequest;
use App\Http\Controllers\Controller;

use App\Services\Student\DeleteService;
use App\Services\Student\UpdateService;
use App\Services\Student\StoreService;
use App\Services\Student\ListService;

use App\Models\Classroom;
use App\Models\Student;

class StudentController extends Controller
{
    public function __construct(
        protected DeleteService $delete,
        protected StoreService $store,
        protected UpdateService $update,
        protected ListService $list,
    ) {}

    public function index( ListRequest $request, Classroom $classroom ) : StudentCollection
    {
        $this->authorize( 'view', $classroom );

        $options = $request->getQueryOptions();

        $columns = $request->safe()->only('fields')['fields'];

        $data = $this->list->execute( $classroom->id, $options, $columns );

        return new StudentCollection( $data['data'], $data['total'], $data['count'], $options );
    }

    public function store( Classroom $classroom, StoreRequest $request ) : StudentResource
    {
        $this->authorize( 'update', $classroom ); // Acho que essa e a autorização certa se não for mudo depois

        $student = $this->store->execute( $classroom, $request->validated() );

        return new StudentResource( $student );
    }

    public function show( Classroom $classroom, Student $student ) : StudentResource
    {
        $this->authorize( 'view', $classroom );

        return new StudentResource( $student );
    }

    public function update( UpdateRequest $request, Classroom $classroom , Student $student ) : StudentResource
    {
        $this->authorize( 'update', $classroom );

        $student = $this->update->execute( $student, $request->validated() );

        return new StudentResource( $student );
    }

    public function destroy( Classroom $classroom, Student $student ) : Response
    {
        $this->authorize( 'update', $classroom );

        $this->delete->execute( $student );

        return response()->noContent( 204 );
    }
}
