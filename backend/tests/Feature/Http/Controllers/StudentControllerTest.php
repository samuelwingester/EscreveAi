<?php

namespace Tests\Feature\Http\Controllers;

use Tests\Feature\Http\Controllers\ControllerTestCase;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;

class StudentControllerTest extends ControllerTestCase
{
    public function test_store_route_success()
    {
        $class = $this->fakeClassroom();

        $response = $this->postJson( '/api/classroom/' . $class->id . '/student', [
            'name'          => 'Teste',
            'writing_level' => 'alfabetico',
            'observations'  => 'teste',
            'birth_date'    => '2009-07-04'
        ]);

        $response->assertStatus( 201 );

        $response->assertJsonPath( 'student.name', 'Teste' );

        $response->assertJsonPath( 'student.writing_level', 'alfabetico' );

        $response->assertJsonPath( 'student.observations', 'teste' );

        $response->assertJsonPath( 'student.birth_date', '2009-07-04' );

        $this->assertDatabaseHas( 'students', [
            'name'          => 'Teste',
            'writing_level' => 'alfabetico',
            'observations'  => 'teste',
            'birth_date'    => '2009-07-04'
        ]);
    }

    public function test_update_route_success()
    {
        $class = $this->fakeClassroom();

        $student = $this->fakeStudent( $class );

        $response = $this->patchJson( '/api/classroom/' . $class->id . '/student/' . $student->id, [
            'name'          => 'Teste',
            'observations'  => 'teste',
        ]);

        $response->assertStatus( 200 );

        $response->assertJsonPath( 'student.name', 'Teste' );

        $response->assertJsonPath( 'student.observations', 'teste' );

        $this->assertDatabaseHas( 'students', [
            'name'          => 'Teste',
            'observations'  => 'teste',
        ]);
    }

    public function test_delete_route_success()
    {
        $class = $this->fakeClassroom();

        $student = $this->fakeStudent( $class );

        $response = $this->deleteJson( '/api/classroom/' . $class->id . '/student/' . $student->id );

        $response->assertStatus( 204 );

        $this->assertDatabaseMissing( 'students', [ 'id' => $student->id ] );
    }

    public function test_index_route_success()
    {
        $classroom = $this->fakeClassroom();

        $this->fakeStudents( $classroom );

        $response = $this->getJson(
            "api/classroom/{$classroom->id}/student?limit=10&offset=0&order_by=name&direction=desc"
        );

        $response->assertOk();

        $response->assertJsonPath('total', 50);

        $response->assertJsonPath('count', 10);

        $response->assertJsonPath('limit', 10);

        $response->assertJsonPath('offset', 0);
    }

    public function test_index_route_next_link()
    {
        $classroom = $this->fakeClassroom();

        $this->fakeStudents( $classroom );

        $response = $this->getJson(
            "api/classroom/{$classroom->id}/student?limit=10&offset=0&order_by=name&direction=desc"
        );

        $response->assertJsonPath(
            'links.next', url("api/classroom/{$classroom->id}/student?limit=10&offset=10&order_by=name&direction=desc")
        );
    }

    public function test_index_route_previous_link_is_null_on_first_page()
    {
        $classroom = $this->fakeClassroom();

        $this->fakeStudents( $classroom );

        $response = $this->getJson(
            "api/classroom/{$classroom->id}/student?limit=10&offset=0&order_by=name&direction=desc"
        );

        $response->assertJsonPath('links.previous', null);
    }

    public function test_index_route_previous_link()
    {
        $classroom = $this->fakeClassroom();

        $this->fakeStudents( $classroom );

        $response = $this->getJson(
            "api/classroom/{$classroom->id}/student?limit=10&offset=20&order_by=name&direction=desc"
        );

        $response->assertJsonPath(
            'links.previous',
            url("api/classroom/{$classroom->id}/student?limit=10&offset=10&order_by=name&direction=desc")
        );
    }

    public function test_index_route_first_link()
    {
        $classroom = $this->fakeClassroom();

        $this->fakeStudents( $classroom );

        $response = $this->getJson(
            "api/classroom/{$classroom->id}/student?limit=10&offset=20&order_by=name&direction=desc"
        );

        $response->assertJsonPath(
            'links.first',
            url("api/classroom/{$classroom->id}/student?limit=10&offset=0&order_by=name&direction=desc")
        );
    }

    public function test_index_route_last_link()
    {
        $classroom = $this->fakeClassroom();

        $this->fakeStudents( $classroom );

        $response = $this->getJson(
            "api/classroom/{$classroom->id}/student?limit=10&offset=0&order_by=name&direction=desc"
        );

        $response->assertJsonPath(
            'links.last',
            url("api/classroom/{$classroom->id}/student?limit=10&offset=40&order_by=name&direction=desc")
        );
    }

    public function test_index_route_next_link_is_null_on_last_page()
    {
        $classroom = $this->fakeClassroom();

        $this->fakeStudents( $classroom );

        $response = $this->getJson(
            "api/classroom/{$classroom->id}/student?limit=10&offset=40&order_by=name&direction=desc"
        );

        $response->assertJsonPath('links.next', null);
    }

    public function test_index_route_last_link_with_partial_page()
    {
        $classroom = $this->fakeClassroom();

        $this->fakeStudents( $classroom, 45 );

        $response = $this->getJson(
            "api/classroom/{$classroom->id}/student?limit=10&offset=0&order_by=name&direction=desc"
        );

        $response->assertJsonPath(
            'links.last', url("api/classroom/{$classroom->id}/student?limit=10&offset=40&order_by=name&direction=desc")
        );
    }

    public function test_index_route_uses_default_query_parameters()
    {
        $classroom = $this->fakeClassroom();

        $this->fakeStudents( $classroom, 30 );

        $response = $this->getJson(
            "api/classroom/{$classroom->id}/student"
        );

        $response->assertOk();

        $response->assertJsonPath('limit', 20);

        $response->assertJsonPath('offset', 0);
    }

    public function test_index_route_rejects_limit_below_minimum()
    {
        $classroom = $this->fakeClassroom();

        $this->fakeStudents( $classroom, 30 );

        $response = $this->getJson( "api/classroom/{$classroom->id}/student?limit=9" );

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors(['limit']);
    }

    public function test_index_route_rejects_limit_above_maximum()
    {
        $classroom = $this->fakeClassroom();

        $this->fakeStudents( $classroom, 30 );

        $response = $this->getJson( "api/classroom/{$classroom->id}/student?limit=201" );

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors(['limit']);
    }

    public function test_index_route_rejects_negative_offset()
    {
        $classroom = $this->fakeClassroom();

        $response = $this->getJson( "api/classroom/{$classroom->id}/student?offset=-1" );

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors(['offset']);
    }

    public function test_index_route_rejects_invalid_order_by()
    {
        $classroom = $this->fakeClassroom();

        $response = $this->getJson( "api/classroom/{$classroom->id}/student?order_by=invalid" );

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors(['order_by']);
    }

    public function test_index_route_rejects_invalid_direction()
    {
        $classroom = $this->fakeClassroom();

        $response = $this->getJson( "api/classroom/{$classroom->id}/student?direction=invalid" );

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors(['direction']);
    }

    public function test_index_route_returns_only_requested_columns()
    {
        $classroom = $this->fakeClassroom();

        Student::factory()->for($classroom)->create([
            'name' => 'Ana',
            'writing_level' => 'alfabetico',
        ]);

        $response = $this->getJson( "api/classroom/{$classroom->id}/student?fields=id,name" );

        $response->assertOk();

        $response->assertJsonStructure([ 'data' => [ '*' => ['id', 'name'] ] ]);

        $response->assertJsonMissingPath('data.0.writing_level');

        $response->assertJsonMissingPath('data.0.birth_date');

        $response->assertJsonPath('data.0.name', 'Ana');
    }

    public function test_index_route_returns_multiple_requested_columns()
    {
        $classroom = $this->fakeClassroom();

        Student::factory()->for($classroom)->create([
            'name' => 'Ana',
            'writing_level' => 'alfabetico',
            'birth_date' => '2010-05-15',
        ]);

        $response = $this->getJson(
            "api/classroom/{$classroom->id}/student?fields=id,name,writing_level,birth_date"
        );

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [ '*' => ['id', 'name', 'writing_level', 'birth_date'] ]
        ]);

        $response->assertJsonPath('data.0.name', 'Ana');

        $response->assertJsonPath('data.0.writing_level', 'alfabetico');

        $response->assertJsonPath('data.0.birth_date', '2010-05-15');
    }

    public function test_index_route_rejects_invalid_column()
    {
        $classroom = $this->fakeClassroom();

        $this->fakeStudent( $classroom );

        $response = $this->getJson( "api/classroom/{$classroom->id}/student?fields=id,hehehe" );

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors(['fields.1']);
    }

    public function test_index_route_returns_all_columns_without_columns_parameter()
    {
        $classroom = $this->fakeClassroom();

        $this->fakeStudent( $classroom );

        $response = $this->getJson( "api/classroom/{$classroom->id}/student" );

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [ '*' => ['id', 'name', 'writing_level', 'birth_date'] ]
        ]);
    }

}
