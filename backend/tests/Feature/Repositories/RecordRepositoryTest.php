<?php

namespace Tests\Feature\Repositories;

use Tests\Feature\Repositories\RepositoryTestCase;

use App\Repositories\RecordRepository;
use App\Models\Record;

class RecordRepositoryTest extends RepositoryTestCase
{
    protected function getRepository(): RecordRepository
    {
        return new RecordRepository();
    }

    protected function getTableName(): string
    {
        return "records";
    }

    protected function getCreateData(): array
    {
        return Record::factory()->withStudent()->withActivity()->make()->getAttributes();
    }

    protected function getUpdateData(): array
    {
        return [ ];
    }

    protected function createModel(): Record
    {
        return Record::factory()->withStudent()->withActivity()->create();
    }
}