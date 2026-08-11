<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Teacher;
use App\Models\Classroom;

class ClassroomControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_classroom_controller_index_sucess(): void
    {
        $response = $this->get('/api/classroom');

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertStatus(200);
        //--------------------------------------------------------
    }

    public function test_classroom_controller_store_success(): void
    {
        $teacher = Teacher::factory()->create();
    
        $response = $this->post('/api/classroom', [
            'name' => 'teste',
            'teacher_id' => $teacher->id
        ]);

        $classroom = Classroom::all()->first();
        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertStatus( 201 );

        $this->assertDatabaseCount( 'classes', 1 );

        $this->assertEquals( $classroom->teacher_id, Teacher::all()->first()->id );
        //--------------------------------------------------------
    }

    public function test_classroom_controller_store_validation_failed(): void
    {
        $data['name'] = fake()->realTextBetween(160, 200);
        $data['teacher_id'] = 0;

        $response = $this->post('/api/classroom', $data); 

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertStatus( 422 );

        $response->assertInvalid( array_keys( $data ) );

        $this->assertDatabaseCount('classes', 0);
        //--------------------------------------------------------
    }

    public function test_classroom_controller_update_success()
    {
        $classroom = classroom::factory()->withTeacher()->create();

        $data['name'] = 'Test';
        
        $response = $this->put('/api/classroom/' . $classroom->id, $data);

        $classroom = Classroom::find( $classroom->id, 'id' )->first();

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertStatus( 204 );

        $this->assertEquals( $data['name'], $classroom->name );
        //--------------------------------------------------------
    }

    public function test_classroom_controller_update_validation_failed()
    {
        $classroom = Classroom::factory()->withTeacher()->create();

        $data['name'] = fake()->realTextBetween(160, 200);

        $response = $this->put('/api/classroom/' . $classroom->id , $data); 

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertStatus( 422 );

        $response->assertInvalid( array_keys( $data ) );
        //--------------------------------------------------------
    }

    public function test_classroom_controller_delete_success()
    {
        $classroom = Classroom::factory()->withTeacher()->create();

        $response = $this->delete('/api/teacher/' . $classroom->id);

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertStatus( 204 );

        $this->assertDatabaseCount('classes', 0);
        //--------------------------------------------------------
    }    
}