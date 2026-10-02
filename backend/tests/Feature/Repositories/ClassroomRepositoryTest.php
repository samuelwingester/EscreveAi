<?php

namespace Tests\Feature\Repositories;

use Tests\Feature\Repositories\RepositoryTestCase;

use App\Repositories\ClassroomRepository;
use App\Models\Classroom;
use App\Models\User;

use App\Repositories\Query\QueryOptions;

class ClassroomRepositoryTest extends RepositoryTestCase
{
    protected ClassroomRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->getRepository();
    }

    protected function getRepository(): ClassroomRepository
    {
        return new ClassroomRepository();
    }

    protected function getTableName(): string
    {
        return "classes";
    }

    protected function getCreateData(): array
    {
        return Classroom::factory()->withTeacher()->make()->getAttributes();
    }

    protected function getUpdateData(): array
    {
        return [ 'name' => 'teste' ];
    }

    protected function createModel(): Classroom
    {
        return Classroom::factory()->withTeacher()->create();
    }


    public function test_get_by_teacher_with_one_filter()
    {
        // Função de tempo do laravel
        // Tentei usar DateTime mas não funcionava direito
        // gpt me mostrou essas funcoes de tempo do laravel agredeço
        // vai ser util futuramente para atividades eu acho
        // Pesquisar mais depois o modulo e chamado { Carbon }
        $teacher = User::factory()->create();

        $time = now();

        // Esse copy e necessario porque as funcoes afetam o objeto e nao retornam um novo
        Classroom::factory()->for($teacher)->count(50)->create( ['created_at' => $time->copy()->subMinute()] );

        Classroom::factory()->for($teacher)->count(25)->create( ['created_at' => $time->copy()->addMinute()] );

        $result1 = $this->repository->getByTeacher( $teacher->id, [['created_at', '<', $time]] );

        $result2 = $this->repository->getByTeacher( $teacher->id, [['created_at', '>', $time]] );

        $this->assertCount( 50, $result1 );

        $this->assertCount( 25, $result2 );
    }

    public function test_get_by_teacher_with_multiple_filters()
    {
        $teacher = User::factory()->create();

        $time = now();

        Classroom::factory()->for($teacher)->count(5)->create( ['name' => 'teste', 'created_at' => $time->copy()->subMinute()] );

        Classroom::factory()->for($teacher)->count(10)->create( ['name' => 'teste', 'created_at' => $time->copy()->addMinute()] );

        $result1 = $this->repository->getByTeacher( $teacher->id, [['name', '=', 'teste'], ['created_at', '>', $time]] );

        $result2 = $this->repository->getByTeacher( $teacher->id, [['name', '=', 'teste'], ['created_at', '<', $time]] );

        $this->assertCount( 10, $result1 );

        $this->assertCount( 5, $result2 );
    }

    public function test_get_by_teacher_with_options_pagination()
    {
        $teacher = User::factory()->create();

        $options = new QueryOptions();

        $options->limit = 10;

        $options->offset = 10;

        Classroom::factory()->for($teacher)->count(50)->create();

        $compare = $this->repository->getByTeacher( $teacher->id );

        $result = $this->repository->getByTeacher( $teacher->id, options:$options );

        $this->assertCount( 10, $result );

        $this->assertEquals( $compare[10]->id, $result[0]->id );
    }

    public function test_get_by_teacher_with_options_order_by()
    {
        $teacher = User::factory()->create();

        $options = new QueryOptions();

        $options->orderBy = "name";

        // Tenho que passar o fake aqui, a factory ta com um metodo merda que atrapalha o sort
        Classroom::factory()->for($teacher)->count(10)->create( ["name" => fake()->name()] );

        $compare = $this->repository->getByTeacher( $teacher->id )->sortBy( "name" );

        $result = $this->repository->getByTeacher( $teacher->id, options:$options  );

        $this->assertEquals( $compare, $result );
    }
}
