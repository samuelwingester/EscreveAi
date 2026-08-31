<?php

namespace Tests\Feature\Repositories;

use Tests\Feature\Repositories\RepositoryTestCase;

use App\Repositories\ClassroomRepository;
use App\Models\Classroom;
use App\Models\User;

use function PHPUnit\Framework\assertTrue;

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

    public function test_get_by_teacher_paginated()
    {
        $teacher = User::factory()->create();

        Classroom::factory()->for( $teacher )->count( 50 )->create();

        $result = $this->repository->getByTeacherPaginated( $teacher->id );

        $result1 = $this->repository->getByTeacherPaginated( $teacher->id, offset:0, limit:20 );
        $result2 = $this->repository->getByTeacherPaginated( $teacher->id, offset:20, limit:20 );
        $result3 = $this->repository->getByTeacherPaginated( $teacher->id, offset:40, limit:20 );

        $this->assertCount( 50, $result );

        $this->assertCount( 20, $result1 );
        $this->assertCount( 20, $result2 );
        $this->assertCount( 10, $result3 );
    }
}
