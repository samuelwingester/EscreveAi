<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

use App\Repositories\Query\QueryOptions;

trait AppliesQueryOptions
{
    #[Scope]
    protected function applyOptions( Builder $query, ?QueryOptions $options )
    {
        if ( $options !== null ){
            $query->orderBy( $options->orderBy, $options->direction );

            if ( $options->limit > 0 )
                $query->limit( $options->limit );

            if ( $options->offset > 0 )
                $query->offset( $options->offset );
        }
    }
}
