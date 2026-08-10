<?php 

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    public function findById( int|string $id ): Model;

    public function findWithColumns( int|string $id, array $columns ): ?Model;

    /**
     * @return Collection<int, Model>|LengthAwarePaginator
     */
    public function getList( array $filters = [], array $columns = ['*'], array $with = [], ?int $perPage = null ): Mixed;

    public function getWhere( array $filters, array $columns = ['*'] ): Collection;

    public function getFirstWhere( array $filters = [] ): ?Model;

    public function getCountWhere( array $filters = [] ): int;

    public function exists( string $field, mixed $value ): bool;

    public function create( array $data ): Model;

    public function update( int|string $id, array $data ): Model;

    public function updateWithModel( Model $model, array $data ): Model;

    public function delete( int|string $id ): bool;

    public function deleteWithModel( Model $model ): bool;
}