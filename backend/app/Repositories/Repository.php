<?php

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryInterface;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

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

    protected function getQueryBuilder( array $filters = [] ): Builder
    {
        $query = $this->modelClass::query();

        foreach ( $filters as $key => $value ) {
            if ( !is_null( $value ) )
                $query->where($key, $value);
        }

        return $query;
    }


    public function findById( int|string $id ): Model
    {
        return $this->modelClass::findOrFail( $id );
    }

    public function findWithColumns( int|string $id, array $columns ): ?Model
    {
        return $this->modelClass::select( $columns )->find( $id );
    }

    /**
     * @return Collection<int, Model>|LengthAwarePaginator
     */
    public function getList( array $filters = [], array $columns = ['*'], array $with = [], ?int $perPage = null ): Mixed
    {
        $query = $this->getQueryBuilder( $filters )->with( $with );

        if ( $perPage )
            return $query->paginate( $perPage, $columns );

        return $query->get( $columns );
    }

    public function getWhere( array $filters, array $columns = ['*'] ): Collection
    {
        return $this->getQueryBuilder( $filters )->get( $columns );
    }

    public function getFirstWhere( array $filters = [] ): ?Model
    {
        return $this->getQueryBuilder( $filters )->firstOrFail();
    }

    public function getCountWhere( array $filters = [] ): int
    {
        return $this->getQueryBuilder( $filters )->count();
    }

    public function exists( string $field, mixed $value ): bool
    {
        return $this->modelClass::where($field, $value)->exists();
    }


    public function create( array $data ): Model
    {
        return $this->modelClass::create( $data );
    }

    public function update( int|string $id, array $data ): Model
    {
        $model = $this->findById( $id );
        $model->update( $data );

        return $model;
    }

    public function updateWithModel( Model $model, array $data ): Model
    {
        $this->validateInstanceOfModel( $model );   
    
        $model->update( $data );

        return $model;
    }

    public function delete( int|string $id ): bool
    {
        $model = $this->findById( $id );

        return $model->deleteOrFail();
    } 

    public function deleteWithModel( Model $model ): bool 
    {
        $this->validateInstanceOfModel( $model );   

        return $model->deleteOrFail();
    }
}