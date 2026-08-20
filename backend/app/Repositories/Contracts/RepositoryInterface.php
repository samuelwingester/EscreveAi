<?php 

namespace App\Repositories\Contracts;

interface RepositoryInterface
{
    public function getById( int|string $id, array $columns = ['*'] ): object;

    public function getAll( array $columns = ['*'] ): mixed;

    public function getWhere( array $filters, array $columns = ['*'] ): mixed;

    public function getFirstWhere( array $filters, array $columns = ['*'] ): object;

    public function getCountAll( ): int;

    public function getCountWhere( array $filters ): int;

    public function exists( array $filters ): bool;

    public function create( array $data ): object;

    public function update( int|string $id, array $data ): object;

    public function updateWithModel( object $model, array $data ): object;

    public function delete( int|string $id ): bool;

    public function deleteWithModel( object $model ): bool;
}