<?php

namespace Tests\Feature;

use App\Models\Classroom;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Teacher;
use App\Models\User;

class TeacherTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_be_created(): void
    {
        $teacher = Teacher::factory()->create();

        $this->assertDatabaseHas( 'teachers', [ 'id' => $teacher->id ] );
    }

    public function test_teacher_has_classroom(): void
    {
        $teacher = Teacher::factory()->create();
        
        $classroom = Classroom::factory()->for( $teacher )->create();

        $this->assertEquals( $teacher->id, $classroom->teacher_id );

        $this->assertInstanceOf( Teacher::class, $classroom->teacher );
    }


    public function test_teacher_belongs_to_user(): void
    {
        $teacher = Teacher::factory()->create();

        $user = $teacher->user;

        $this->assertEquals( $teacher->user_id, $user->id );

        $this->assertDatabaseHas('teachers', [ 'user_id' => $user->id ]);
    }

    public function test_teacher_user_can_be_deleted(): void 
    {
        $teacher = Teacher::factory()->create();

        $teacher->user()->delete();

        $this->assertModelMissing( $teacher );

        $this->assertDatabaseCount( 'teachers', 0 );
    }

    public function test_teacher_can_be_updated(): void
    {
        $teacher = Teacher::factory()->create();

        $teacher->user()->update( ['name' => 'test'] );

        $teacher->refresh();

        $this->assertEquals('test', $teacher->name);

        $this->assertDatabaseHas('users', [
            'id' => $teacher->user_id,
            'name' => 'test',
        ]);
    }

    public  function test_teacher_acessors_work(): void
    {
        $user = User::factory()->teacher()->create();

        $user->update( [ 'secondary_email' => 'test@test' ] );

        $teacher = Teacher::factory()->for( $user )->create();

        $teacher->load( 'user' );

        $this->assertEquals( $user->name, $teacher->name );

        $this->assertEquals( $user->email, $teacher->email );

        $this->assertEquals( $user->birth_date, $teacher->birthDate );

        $this->assertEquals( $user->gender, $teacher->gender );

        $this->assertEquals( $user->secondary_email, $teacher->secondaryEmail );
    }
}
