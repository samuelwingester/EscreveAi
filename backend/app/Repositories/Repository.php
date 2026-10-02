<?php

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryInterface;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;

abstract class Repository implements RepositoryInterface
{
    /**
     * Model que sera implementada
     *
     * @var class-string<Model>
     */
    protected string $modelClass;

    public function __construct()
    {
        if ( !isset( $this->modelClass ) || !is_subclass_of( $this->modelClass, Model::class ) ){
            throw new InvalidArgumentException('Model class is not defined or is invalid.');
        }
    }

    protected function validateInstanceOfModel( Model $model ): void
    {
        if ( ! $model instanceof $this->modelClass  )
            throw new InvalidArgumentException( 'Model ' . $model::class . ' is not instance of ' . $this->modelClass );
    }

    /** @throws ModelNotFoundException */
    public function getById( int|string $id, array $columns = ['*'] ): Model
    {
        return $this->modelClass::findOrFail( $id, $columns );
    }

    public function getAll( array $columns = ['*'] ): Collection
    {
        return $this->modelClass::all( $columns );
    }

    public function getWhere( array $filters, array $columns = ['*'] ): Collection
    {
        return $this->modelClass::where( $filters )->get( $columns );
    }

    /** @throws ModelNotFoundException */
    public function getFirstWhere( array $filters, array $columns = ['*'] ): Model
    {
        return $this->modelClass::where( $filters )->firstOrFail( $columns );
    }

    public function getCountWhere( array $filters ): int
    {
        return $this->modelClass::where( $filters )->count();
    }

    public function getCountAll(): int
    {
        return $this->modelClass::count();
    }

    public function exists( array $filters ): bool
    {
        return $this->modelClass::where( $filters )->exists();
    }

    public function create( array $data ): Model
    {
        return $this->modelClass::create( $data );
    }

    /** @throws ModelNotFoundException */
    public function update( int|string $id, array $data ): Model
    {
        $model = $this->modelClass::findOrFail( $id );

        $model->update( $data );

        return $model;
    }

    public function updateWithModel( object $model, array $data ): Model
    {
        $this->validateInstanceOfModel( $model );

        $model->update( $data );

        return $model;
    }

    /** @throws ModelNotFoundException */
    public function delete( int|string $id ): bool
    {
        $model = $this->modelClass::findOrFail( $id );

        return $model->deleteOrFail();
    }

    public function deleteWithModel( object $model ): bool
    {
        $this->validateInstanceOfModel( $model );

        return $model->deleteOrFail();
    }
}
