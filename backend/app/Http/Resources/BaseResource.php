<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Model;

use stdClass;

abstract class BaseResource extends JsonResource
{
    /** verifica a existencia de uma propriedade de um objeto */
    protected function whenExists( string $name ) : mixed
    {
        // determina o tipo de objeto se é stdClass ou Model do laravel, e verifica se a propriedade existe
        $exists = match( true ){
            $this->resource instanceof Model =>
                array_key_exists( $name, $this->resource->getAttributes() ),

            $this->resource instanceof stdClass =>
                property_exists( $this->resource, $name ),

            default => false
        };

        return $this->when( $exists, data_get( $this->resource, $name ) );
    }
}
