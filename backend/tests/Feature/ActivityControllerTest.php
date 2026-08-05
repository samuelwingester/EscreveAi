<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

use App\Models\Activity;
use App\Models\Classroom;

class ActivityControllerTest extends TestCase
{
    use RefreshDatabase;    

    public function test_activity_controller_index_success(): void
    {
        $response = $this->get('/api/activity');

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertStatus( 200 );
        //--------------------------------------------------------
    }

    public function test_activity_controller_store_success_with_attachments(): void
    {
        $classroom = Classroom::factory()->withTeacher()->create();

        $file = UploadedFile::fake()->create( 'test', 200, 'application/pdf' );

        $response = $this->post('/api/activity', [
            'class_id'      => $classroom->id,
            'title'         => 'test',
            'description'   => 'test',
            'attachments'   => [
                [
                    'url'   => 'https://google.com',
                    'file'  => null,
                ],
                [
                    'file'  => $file,
                ]
            ]
        ]);

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertStatus( 201 );
        //--------------------------------------------------------
    }
}
