<?php

namespace Tests\Feature\Repositories;

use Tests\Feature\Repositories\RepositoryTestCase;

use App\Repositories\ClassroomRepository;
use App\Models\Classroom;

class ClassroomRepositoryTest extends RepositoryTestCase
{
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
}