<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;

use App\Enums\Gender;
use App\Enums\WritingLevel;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_controller_index_sucess(): void
    {
        $response = $this->get('/student');

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertStatus(200);

        $response->assertViewIs( 'view::student.index' );
        //--------------------------------------------------------
    }

    public function test_student_controller_store_success(): void
    {
        $this->withoutExceptionHandling();

        $classroom = Classroom::factory()->withTeacher()->create();

        $response = $this->post('/student', [
            'email'         => fake()->email(),
            'password'      => '88888888',
            'name'          => fake()->name(),
            'birth_date'    => fake()->date( 'Y-m-d', '-4 years' ),
            'class_id'      => $classroom->id,
            'password_confirmation' => '88888888'
        ]);

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertSessionHas('success');

        $response->assertRedirect();

        $this->assertDatabaseCount('users', 2);

        $this->assertDatabaseCount('students', 1);

        $this->assertEquals( $classroom->students()->first()->user_id, User::all()->last()->id );
        //--------------------------------------------------------
    }

    public function test_student_controller_store_validation_failed(): void
    {
        $data['email'] = 'hrslkahfbk';
        $data['name'] = fake()->realTextBetween(160, 200);
        $data['birth_date'] = '2026-06-06';
        $data['class_id'] = 'haha';

        $response = $this->post( '/student', $data ); 

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertInvalid( array_keys( $data ) );

        $this->assertDatabaseCount('students', 0);

        $this->assertDatabaseCount('users', 0);
        //--------------------------------------------------------
    }

    public function test_student_controller_update_success()
    {
        $student = Student::factory()->withClassroom()->create();

        $data['secondary_email'] = 'test@test';
        $data['name'] = 'Test';
        $data['birth_date'] = '2020-06-06';
        $data['gender'] = 'woman';
        $data['writing_level'] = 'alfabetico';
        $data['observations'] = fake()->text(50);

        $response = $this->put('/student/' . $student->id, $data);

        $student = Student::find( $student->id )->first();

        $student->load( 'user' );
        
        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertSessionHas('success');

        $response->assertRedirect();

        $this->assertEquals( $data['secondary_email'], $student->secondary_email );

        $this->assertEquals( $data['name'], $student->name );

        $this->assertEquals( $data['birth_date'], $student->birth_date );

        $this->assertEquals( WritingLevel::ALFABETICO, $student->writing_level );

        $this->assertEquals( Gender::WOMAN, $student->gender );
    
        $this->assertEquals( $data['observations'], $student->observations );
        //--------------------------------------------------------
    }

    public function test_student_controller_update_validation_failed()
    {
        $student = Student::factory()->withClassroom()->create();

        $data['secondary_email'] = 'hrslkahfbk';
        $data['name'] = fake()->realTextBetween(160, 200);
        $data['birth_date'] = '2026-06-06';
        $data['gender'] = 'haha';
        $data['writing_level'] = 'haha';

        $response = $this->put('/student/' . $student->id, $data);

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertInvalid( array_keys( $data ) );
        //--------------------------------------------------------
    }

    public function test_student_controller_delete_success()
    {
        $student = Student::factory()->withClassroom()->create();

        $response = $this->delete('/student/' . $student->id);

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $response->assertSessionHas('success');

        $response->assertRedirect();

        $this->assertDatabaseCount('students', 0);

        $this->assertDatabaseCount('users', 1);
        //--------------------------------------------------------
    }    
}
