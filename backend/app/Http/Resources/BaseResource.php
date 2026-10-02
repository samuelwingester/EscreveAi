<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Model;

class BaseResource extends JsonResource
{
    /** verifica se a propriedade existe usando metodos diferentes dependendo do tipo de objeto e retorna ela se existir */
    protected function whenExists( string $column ) : mixed // Gambiarra Daora, nt: não e mais daora
    {
        // determina o tipo de objeto se stdClass ou Model do laravel, e verifica se a propriedade existe
        $exists = $this->resource instanceof Model  ? array_key_exists($column, $this->resource->getAttributes())
                                                    : property_exists($this->resource, $column);

        // o segundo parametro e uma gambiarra do php pra puxar uma propriedade dinamicamente
        // pela funcao anonima que previne o erro de execução do php em relação a propriedade não existir
        // depois executa o metodo padrão de when do JsonResource
        return $this->when( $exists, fn () => $this->resource->{$column} );
    }
}
