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
        return "users";
    }

    protected function getCreateData(): array
    {
        return User::factory()->teacher()->make()->getAttributes();
    }

    protected function getUpdateData(): array
    {
        return [ 'name' => 'teste' ];
    }

    protected function createModel(): Model
    {
        return User::factory()->teacher()->create();
    }
}