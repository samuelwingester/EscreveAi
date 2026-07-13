<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Classroom;
use App\Models\Teacher;
use App\Models\User;

class ClassroomTest extends TestCase
{
    use RefreshDatabase;

    public function test_classroom_can_be_created(): void
    {
        $this->withoutExceptionHandling();

        $classroom = Classroom::factory()->withTeacher()->create();

        $this->assertDatabaseHas( 'classes', [ 'id' => $classroom->id ] );
    }

    public function test_classroom_belongs_to_teacher(): void
    {
        $teacher = Teacher::factory()->create();
        
        $classroom = Classroom::factory()->for( $teacher )->create();

        $this->assertEquals( $teacher->id, $classroom->teacher_id );

        $this->assertInstanceOf( Teacher::class, $classroom->teacher );
    }

    public function test_classroom_can_be_deleted(): void 
    {
        $classroom = Classroom::factory()->withTeacher()->create();

        $classroom->delete();

        $this->assertModelMissing( $classroom );

        $this->assertDatabaseCount( 'classes', 0 );
    }

    public function test_classroom_can_be_deleted_on_cascade(): void 
    {
        $classroom = Classroom::factory()->withTeacher()->create();

        $teacher = $classroom->teacher;

        $teacher->delete();

        $this->assertModelMissing( $classroom );

        $this->assertModelMissing( $teacher );

        $this->assertDatabaseCount( 'classes', 0 );

        $this->assertDatabaseCount( 'teachers', 0 );
    }

    public function test_classroom_can_be_updated(): void
    {
        $classroom = Classroom::factory()->withTeacher()->create();

        $classroom->update( ['name' => 'test'] );

        $classroom->refresh();

        $this->assertEquals('test', $classroom->name);

        $this->assertDatabaseHas('classes', [
            'id' => $classroom->id,
            'name' => 'test',
        ]);
    }
}
