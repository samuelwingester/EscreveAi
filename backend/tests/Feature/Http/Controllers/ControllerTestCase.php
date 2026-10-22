<?php

namespace Tests\Feature\Http\Controllers;

use Laravel\Sanctum\Sanctum;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;

use App\Models\User;
use App\Models\Classroom;
use App\Models\Student;

abstract class ControllerTestCase extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->fakeUser();
    }

    protected function fakeUser() : User
    {
        $user = User::factory()->teacher()->create();

        Sanctum::actingAs( $user );

        return $user;
    }

    protected function fakeClassroom() : Classroom
    {
        return Classroom::factory()->for( $this->user )->create();
    }

    protected function fakeStudent( Classroom $classroom ) : Student
    {
        return Student::factory()->for( $classroom )->create();
    }

    protected function fakeStudents( Classroom $classroom, int $count = 50 ) : void
    {
        Student::factory()->for( $classroom )->count( $count )->create();
    }
}
