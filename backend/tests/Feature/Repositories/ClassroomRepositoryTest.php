<?php

namespace Tests\Feature\Repositories;

use Illuminate\Database\Eloquent\Model;

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
        return Classroom::factory()->withTeacher()->make()->toArray();
    }

    protected function getUpdateData(): array
    {
        return [ 'name' => 'teste' ]; //possivelmente mudar
    }

    protected function createModel(): Model
    {
        return Classroom::factory()->withTeacher()->create();
    }
}