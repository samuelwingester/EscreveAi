<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Http\UploadedFile;

use Tests\Feature\Http\Controllers\ControllerTestCase;

use App\Models\Activity;
use App\Models\Classroom;

class ActivityControllerTest extends ControllerTestCase
{
    public function test_store_success_with_attachments()
    {
        $classroom = $this->fakeClassroom();

        $file = UploadedFile::fake()->create( 'test', 200, 'application/pdf' );

        $response = $this->postJson( '/api/classroom/'. $classroom->id . '/activity', [
            'title'         => 'Teste',
            'description'   => 'Teste',
            'attachments'   => [
                [ 'url'   => 'https://google.com' ],
                [ 'file'  => $file ]
            ]
        ]);

        $response->assertStatus( 201 );

        $response->dump();
    }
}
