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
        $response = $this->get('/activity');

        $response->assertStatus(200);
        
        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertStatus(200);

        $response->assertViewIs( 'view::activity.index' );
        //--------------------------------------------------------
    }

    public function test_activity_controller_store_success_with_attachments(): void
    {
        $classroom = Classroom::factory()->withTeacher()->create();

        $file = UploadedFile::fake()->create( 'test', 200, 'application/pdf' );

        $response = $this->post('/activity', [
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
        $response->assertSessionHas('success');
        //--------------------------------------------------------
    }
}
