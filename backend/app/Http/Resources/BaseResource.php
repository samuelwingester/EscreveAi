<?php

namespace App\Http\Resources;

use stdClass;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class BaseResource extends JsonResource
{
    protected bool $includeAttachments = false;

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

    protected function beforeResolve( $request ) : void
    {
        // Exemplo: carregar relacionamentos ou logs automáticos
    }

    final public function toArray( $request ) : array {
        $data = $this->toResource( $request );

        $data['created_at'] = $this->whenExists('created_at');
        $data['updated_at'] = $this->whenExists('updated_at');

        return $data;
    }

    abstract protected function toResource( Request $request ) : array;
}
