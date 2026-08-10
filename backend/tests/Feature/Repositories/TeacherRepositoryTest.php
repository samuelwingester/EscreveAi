<?php

namespace Tests\Feature\Repositories;

use Illuminate\Database\Eloquent\Model;

use Tests\Feature\Repositories\RepositoryTestCase;
use App\Repositories\TeacherRepository;

use App\Models\Teacher;
use App\Models\User;

class TeacherRepositoryTest extends RepositoryTestCase
{
    protected function getRepository(): TeacherRepository
    {
        return new TeacherRepository();
    }

    protected function getTableName(): string
    {
        return "teachers";
    }

    protected function getCreateData(): array
    {
        return Teacher::factory()->make()->toArray();
    }

    protected function getUpdateData(): array
    {
        return [ 'name' => 'teste' ]; //possivelmente mudar
    }

    protected function createModel(): Model
    {
        return Teacher::factory()->create();
    }
}