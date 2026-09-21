<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\Classroom;
use Laravel\Sanctum\Sanctum;
use App\Models\Enums\Shift;

class ClassroomControllerTest extends TestCase
{
    use RefreshDatabase;

    private function fakeUser() : User
    {
        $user = User::factory()->teacher()->create();

        Sanctum::actingAs( $user );

        return $user;
    }

    public function test_store_route_success()
    {
        $user = $this->fakeUser();

        $response = $this->postJson('/api/classroom', [
            'name'      => '3A2',
            'school'    => 'COTEMIG',
            'shift'     => Shift::MANHA->value,
        ]);

        $response->dump();
        $response->assertStatus( 201 );

        $response->assertJsonPath( 'classroom.name', '3A2' );

        $response->assertJsonPath( 'classroom.school', 'COTEMIG' );

        $response->assertJsonPath( 'classroom.shift', Shift::MANHA->value );

        $this->assertDatabaseHas( 'classes', [
            'name'          => '3A2',
            'school'        => 'COTEMIG',
            'shift'         => Shift::MANHA->value,
            'teacher_id'    => $user->id,
        ]);
    }

    public function test_store_route_failure() // Melhorar depois
    {
        $user = $this->fakeUser();

        $response = $this->postJson('/api/classroom', [
            'name'      => '3A2',
            'school'    => 'COTEMIG',
            'shift'     => 'aikhsgbfdouadhb',
        ]);

        $response->assertStatus( 422 );
    }

    public function test_update_route_success()
    {
        $user = $this->fakeUser();

        $classroom = Classroom::factory()->for( $user )->create();

        $response = $this->patchJson('/api/classroom/' . $classroom->id, [
            'name'      => '3A2',
            'school'    => 'COTEMIG',
            'shift'     => Shift::MANHA->value,
        ]);

        $response->assertStatus( 200 );

        $response->assertJsonPath( 'classroom.name', '3A2' );

        $response->assertJsonPath( 'classroom.school', 'COTEMIG' );

        $response->assertJsonPath( 'classroom.shift', Shift::MANHA->value );

        $this->assertDatabaseHas( 'classes', [
            'name'          => '3A2',
            'school'        => 'COTEMIG',
            'shift'         => Shift::MANHA->value,
            'teacher_id'    => $user->id,
        ]);
    }

    public function test_update_route_failure() // Melhorar depois
    {
        $user = $this->fakeUser();

        $classroom = Classroom::factory()->for( $user )->create();

        $response = $this->patchJson('/api/classroom/' . $classroom->id, [
            'name'      => '3A2',
            'school'    => 'COTEMIG',
            'shift'     => 'alisgfadb',
        ]);

        $response->assertStatus( 422 );
    }

    public function test_index_route_success()
    {
        $user = $this->fakeUser();

        $classrooms = Classroom::factory()->for($user)->count(500)->create();

        $response = $this->getJson( 'api/classroom?limit=10&offset=0&order_by=name&direction=desc' );

        $response->assertOk();

        $response->assertJsonPath('total', $classrooms->count());

        $response->assertJsonPath('count', 10);

        $response->assertJsonPath('limit', 10);

        $response->assertJsonPath('offset', 0);
    }

    public function test_index_route_next_link()
    {
        $user = $this->fakeUser();

        Classroom::factory()->for($user)->count(50)->create();

        $response = $this->getJson( 'api/classroom?limit=10&offset=0&order_by=name&direction=desc' );

        $response->assertJsonPath( 'links.next', url('api/classroom?limit=10&offset=10&order_by=name&direction=desc') );
    }

    public function test_index_route_previous_link_is_null_on_first_page()
    {
        $user = $this->fakeUser();

        Classroom::factory()->for($user)->count(50)->create();

        $response = $this->getJson( 'api/classroom?limit=10&offset=0&order_by=name&direction=desc' );

        $response->assertJsonPath('links.previous', null);
    }

    public function test_index_route_previous_link()
    {
        $user = $this->fakeUser();

        Classroom::factory()->for($user)->count(50)->create();

        $response = $this->getJson( 'api/classroom?limit=10&offset=20&order_by=name&direction=desc' );

        $response->assertJsonPath( 'links.previous', url('api/classroom?limit=10&offset=10&order_by=name&direction=desc') );
    }

    public function test_index_route_first_link()
    {
        $user = $this->fakeUser();

        Classroom::factory()->for($user)->count(50)->create();

        $response = $this->getJson( 'api/classroom?limit=10&offset=20&order_by=name&direction=desc' );

        $response->assertJsonPath( 'links.first', url('api/classroom?limit=10&offset=0&order_by=name&direction=desc') );
    }

    public function test_index_route_last_link()
    {
        $user = $this->fakeUser();

        Classroom::factory()->for($user)->count(50)->create();

        $response = $this->getJson( 'api/classroom?limit=10&offset=0&order_by=name&direction=desc' );

        $response->assertJsonPath( 'links.last', url('api/classroom?limit=10&offset=40&order_by=name&direction=desc') );
    }

    public function test_index_route_next_link_is_null_on_last_page()
    {
        $user = $this->fakeUser();

        Classroom::factory()->for($user)->count(50)->create();

        $response = $this->getJson( 'api/classroom?limit=10&offset=40&order_by=name&direction=desc' );

        $response->assertJsonPath('links.next', null);
    }

    public function test_index_route_last_link_with_partial_page()
    {
        $user = $this->fakeUser();

        Classroom::factory()->for($user)->count(45)->create();

        $response = $this->getJson( 'api/classroom?limit=10&offset=0&order_by=name&direction=desc' );

        $response->assertJsonPath( 'links.last', url('api/classroom?limit=10&offset=40&order_by=name&direction=desc') );
    }

    public function test_index_route_uses_default_query_parameters()
    {
        $user = $this->fakeUser();

        Classroom::factory()->for($user)->count(30)->create();

        $response = $this->getJson( 'api/classroom' );

        $response->assertOk();

        $response->assertJsonPath('limit', 20);

        $response->assertJsonPath('offset', 0);
    }

    public function test_index_route_rejects_limit_below_minimum()
    {
        $user = $this->fakeUser();

        Classroom::factory()->for($user)->count(30)->create();

        $response = $this->getJson( 'api/classroom?limit=9' );

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors(['limit']);
    }

    public function test_index_route_rejects_limit_above_maximum()
    {
        $user = $this->fakeUser();

        Classroom::factory()->for($user)->count(30)->create();

        $response = $this->getJson( 'api/classroom?limit=201' );

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors(['limit']);
    }

    public function test_index_route_rejects_negative_offset()
    {
        $user = $this->fakeUser();

        Classroom::factory()->for($user)->count(30)->create();

        $response = $this->getJson( 'api/classroom?offset=-1' );

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors(['offset']);
    }

    public function test_index_route_rejects_invalid_order_by()
    {
        $user = $this->fakeUser();

        $response = $this->getJson( 'api/classroom?order_by=invalid' );

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors(['order_by']);
    }

    public function test_index_route_rejects_invalid_direction()
    {
        $user = $this->fakeUser();

        $response = $this->getJson( 'api/classroom?direction=invalid' );

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors(['direction']);
    }

    public function test_index_route_returns_only_requested_columns()
    {
        $user = $this->fakeUser();

        Classroom::factory()->for($user)->create([
            'name'   => '3A2',
            'school' => 'COTEMIG',
            'shift'  => Shift::MANHA->value,
        ]);

        $response = $this->getJson( 'api/classroom?columns=id,name' );

        //dd($response);

        $response->assertOk();

        $response->assertJsonStructure([ 'data' => [ '*' => [ 'id', 'name' ] ] ]);

        $response->assertJsonMissingPath('data.0.school');

        $response->assertJsonMissingPath('data.0.shift');

        $response->assertJsonPath('data.0.name', '3A2');
    }

    public function test_index_route_returns_multiple_requested_columns()
    {
        $user = $this->fakeUser();

        Classroom::factory()->for($user)->create([
            'name'   => '3A2',
            'school' => 'COTEMIG',
            'shift'  => Shift::MANHA->value,
        ]);

        $response = $this->getJson( 'api/classroom?columns=id,name,school,shift' );

        $response->assertOk();

        $response->assertJsonStructure([ 'data' => [ '*' => [ 'id', 'name', 'school', 'shift' ] ] ]);

        $response->assertJsonPath('data.0.name', '3A2');

        $response->assertJsonPath('data.0.school', 'COTEMIG');

        $response->assertJsonPath('data.0.shift', Shift::MANHA->value);
    }

    public function test_index_route_rejects_invalid_column()
    {
        $user = $this->fakeUser();

        Classroom::factory()->for($user)->create();

        $response = $this->getJson( 'api/classroom?columns=id,hehehe' );

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors(['columns.1']);
    }

    public function test_index_route_returns_all_columns_without_columns_parameter()
    {
        $user = $this->fakeUser();

        Classroom::factory()->for($user)->create([
            'name'   => '3A2',
            'school' => 'COTEMIG',
            'shift'  => Shift::MANHA->value,
        ]);

        $response = $this->getJson( 'api/classroom' );

        $response->assertOk();

        $response->assertJsonStructure([ 'data' => [ '*' => [ 'id', 'name', 'school', 'shift', 'active', ] ] ]);
    }
}
