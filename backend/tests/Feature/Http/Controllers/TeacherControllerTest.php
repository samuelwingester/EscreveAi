<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Teacher;
use App\Models\Student;
use App\Models\User;

use App\Enums\Gender;

class TeacherControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_controller_index_sucess(): void
    {
        $response = $this->get('/api/teacher');

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertStatus(200);
        //--------------------------------------------------------
    }

    public function test_teacher_controller_store_success(): void
    {
        $response = $this->post('/api/teacher', [
            'email'         => fake()->email(),
            'password'      => '88888888',
            'name'          => fake()->name(),
            'birth_date'    => fake()->date( 'Y-m-d', '-4 years' ),
            'password_confirmation' => '88888888'
        ]);

        $teacher = Teacher::all()->first();

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertStatus(201);

        $this->assertDatabaseCount('users', 1);

        $this->assertDatabaseCount('teachers', 1);

        $this->assertEquals( $teacher->user_id, User::all()->first()->id );
        //--------------------------------------------------------
    }

    public function test_teacher_controller_store_validation_failed(): void
    {
        $data['email'] = 'hrslkahfbk';
        $data['name'] = fake()->realTextBetween(160, 200);
        $data['birth_date'] = '2026-06-06';

        $response = $this->post('/api/teacher', $data); 

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertStatus( 422 );

        $response->assertInvalid( array_keys( $data ) );

        $this->assertDatabaseCount('teachers', 0);

        $this->assertDatabaseCount('users', 0);
        //--------------------------------------------------------
    }

    public function test_teacher_controller_update_success()
    {
        $teacher = Teacher::factory()->create();

        $data['secondary_email'] = 'test@test';
        $data['name'] = 'Test';
        $data['birth_date'] = '2020-06-06';
        $data['gender'] = 'woman';

        $response = $this->put('/api/teacher/' . $teacher->id, $data);

        $teacher = Teacher::find( $teacher->id, 'id' )->first();

        $teacher->load( 'user' );
        
        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertStatus( 204 );

        $this->assertEquals( $data['secondary_email'], $teacher->secondary_email );

        $this->assertEquals( $data['name'], $teacher->name );

        $this->assertEquals( $data['birth_date'], $teacher->birth_date );

        $this->assertEquals( Gender::WOMAN, $teacher->gender );
        //--------------------------------------------------------
    }

    public function test_teacher_controller_update_validation_failed()
    {
        $teacher = Teacher::factory()->create();

        $data['secondary_email'] = 'hrslkahfbk';
        $data['name'] = fake()->realTextBetween(160, 200);
        $data['birth_date'] = '2026-06-06';
        $data['gender'] = 'haha';

        $response = $this->put('/api/teacher/' . $teacher->id, $data);

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertStatus( 422 );

        $response->assertInvalid( array_keys( $data ) );
        //--------------------------------------------------------
    }

    public function test_teacher_controller_delete_success()
    {
        $teacher = Teacher::factory()->create();

        $response = $this->delete('/api/teacher/' . $teacher->id);

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertStatus( 204 );

        $this->assertDatabaseCount('teachers', 0);

        $this->assertDatabaseCount('users', 0);
        //--------------------------------------------------------
    }    
}