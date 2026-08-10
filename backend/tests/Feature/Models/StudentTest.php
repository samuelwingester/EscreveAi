<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Student;
use App\Models\Classroom;
use App\Models\User;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_be_created(): void
    {
        $student = Student::factory()->withClassroom()->create();

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $this->assertDatabaseHas( 'students', [ 'id' => $student->id ] );
        //--------------------------------------------------------
    }

    public function test_student_belongs_to_classroom(): void
    {
        $classroom = Classroom::factory()->withTeacher()->create();

        $student = Student::factory()->for( $classroom )->create();

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $this->assertEquals( $student->class_id, $classroom->id );

        $this->assertDatabaseHas('students', [ 'class_id' => $classroom->id ]);

        $this->assertInstanceOf( Classroom::class, $student->classroom );
        //--------------------------------------------------------
    }


    public function test_student_belongs_to_user(): void
    {
        $student = Student::factory()->withClassroom()->create();

        $user = $student->user;

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $this->assertEquals( $student->user_id, $user->id );

        $this->assertDatabaseHas('students', [ 'user_id' => $user->id ]);
        //--------------------------------------------------------
    }

    public function test_student_user_can_be_deleted(): void 
    {
        $student = Student::factory()->withClassroom()->create();

        $student->user()->delete();

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $this->assertModelMissing( $student );

        $this->assertDatabaseCount( 'students', 0 );
        //--------------------------------------------------------
    }

    public function test_student_can_be_updated(): void
    {
        $student = Student::factory()->withClassroom()->create();

        $student->user()->update( ['name' => 'test'] );

        $student->refresh();

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $this->assertEquals('test', $student->name);

        $this->assertDatabaseHas('users', [
            'id' => $student->user_id,
            'name' => 'test',
        ]);
        //--------------------------------------------------------
    }

    public function test_student_acessors_work(): void
    {
        $user = User::factory()->student()->create();

        $user->update( [ 'secondary_email' => 'test@test' ] );

        $student = Student::factory()->for( $user )->withClassroom()->create();

        $student->load( 'user' );

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $this->assertEquals( $user->name, $student->name );

        $this->assertEquals( $user->email, $student->email );

        $this->assertEquals( $user->birth_date, $student->birthDate );

        $this->assertEquals( $user->gender, $student->gender );

        $this->assertEquals( $user->secondary_email, $student->secondaryEmail );
        //--------------------------------------------------------
    }
}
