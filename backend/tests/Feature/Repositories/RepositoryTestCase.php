<?php

namespace Tests\Feature\Repositories;

use App\Repositories\Contracts\RepositoryInterface;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class RepositoryTestCase extends TestCase
{
    use RefreshDatabase;

    protected RepositoryInterface $baseRepository;

    protected string $table;

    protected array $createData;

    protected array $updateData;

    abstract protected function getRepository(): RepositoryInterface;

    abstract protected function getTableName(): string;

    abstract protected function getCreateData(): array;

    abstract protected function getUpdateData(): array;

    abstract protected function createModel(): Model;

    protected function setUp(): void
    {
        parent::setUp();

        $this->baseRepository = $this->getRepository();
        $this->table = $this->getTableName();
        $this->createData = $this->getCreateData();
        $this->updateData = $this->getUpdateData();
    }

    protected function createModels( int $count ): void
    {
        for ( $i = 0; $i < $count; $i++ )
            $this->createModel();
    }

    public function test_create(): void
    {
        $model = $this->baseRepository->create( $this->createData );

        $this->assertDatabaseCount( $this->table, 1 );

        $this->assertDatabaseHas( $this->table, array_merge( [ 'id' => $model->id ], $this->createData ) );
    }

    public function test_update(): void
    {
        $model = $this->createModel();

        $model = $this->baseRepository->update( $model->id, $this->updateData );

        $model->refresh();

        $this->assertDatabaseHas( $this->table, array_merge( [ 'id' => $model->id ], $this->updateData ) );
    }

    public function test_update_with_model(): void
    {
        $model = $this->createModel();

        $model = $this->baseRepository->updateWithModel( $model, $this->updateData );

        $model->refresh();

        $this->assertDatabaseHas( $this->table, array_merge( [ 'id' => $model->id ], $this->updateData ) );
    }

    public function test_delete(): void
    {
        $model = $this->createModel();

        $result = $this->baseRepository->delete( $model->id );

        $this->assertTrue( $result );

        $this->assertDatabaseCount( $this->table, 0 );

        $this->assertDatabaseMissing( $this->table, [ 'id' => $model->id ]);
    }

    public function test_delete_with_model(): void
    {
        $model = $this->createModel();

        $result = $this->baseRepository->deleteWithModel( $model );

        $this->assertTrue( $result );

        $this->assertDatabaseCount( $this->table, 0 );

        $this->assertDatabaseMissing( $this->table, [ 'id' => $model->id ]);
    }

    public function test_get_by_id(): void
    {
        $model = $this->createModel();

        $found = $this->baseRepository->getById( $model->id );

        $this->assertSame( $model->id, $found->id );

        $this->assertTrue( $model->is( $found ) );
    }

    public function test_get_by_id_failure(): void
    {
        $this->expectException( ModelNotFoundException::class );

        $this->baseRepository->getById( 1000 );
    }

    public function test_get_with_columns(): void
    {
        $model = $this->createModel();

        $found = $this->baseRepository->getById( $model->id, [ 'id' ] );

        $this->assertNotNull( $found );

        $this->assertSame( $model->id, $found->id );
    }

    public function test_get_all(): void
    {
        $this->createModels( 5 );

        $list = $this->baseRepository->getAll();

        $this->assertCount( 5, $list );
    }

    public function test_get_where(): void
    {
        $model = $this->createModel();

        $result = $this->baseRepository->getWhere( [ 'id' => $model->id ] );

        $this->assertCount( 1, $result );

        $this->assertTrue( $model->is( $result->first() ) );
    }

    public function test_get_first_where(): void
    {
        $model = $this->createModel();

        $found = $this->baseRepository->getFirstWhere( [ 'id' => $model->id ] );

        $this->assertTrue( $model->is( $found ) );
    }

    public function test_get_first_where_failure(): void
    {
        $this->expectException( ModelNotFoundException::class );

        $this->baseRepository->getFirstWhere( [ 'id' => 1000 ] );
    }

    public function test_get_count_all(): void
    {
        $this->createModels( 10 );

        $count = $this->baseRepository->getCountAll();

        $this->assertSame( 10, $count );
    }

    public function test_get_count_where(): void
    {
        $model = $this->createModel();

        $this->createModels( 5 );

        $count = $this->baseRepository->getCountWhere( [ 'id' => $model->id ] );

        $this->assertSame( 1, $count );
    }

    public function test_exists(): void
    {
        $model = $this->createModel();

        $result = $this->baseRepository->exists( [ 'id' => $model->id ] );

        $this->assertTrue( $result );
    }

    public function test_exists_failure(): void
    {
        $result = $this->baseRepository->exists( [ 'id' => 1000 ] );

        $this->assertFalse( $result );
    }
}
