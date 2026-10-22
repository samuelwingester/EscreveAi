<?php

namespace App\Http\Resources;

use stdClass;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Model;

use App\Http\Resources\Attachment\AttachmentResource;
use App\Models\Contracts\HasAttachmentsContract;

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

    /** Carrega os anexos dinamicamente de uma model que os possui */
    public function loadAttachments() : static
    {
        if ( $this->resource instanceof Model &&
             $this->resource instanceof HasAttachmentsContract
        ){
            $this->resource->loadMissing('attachments');
            $this->includeAttachments = true;
        }

        return $this;
    }

    public function resolve( $request = null ) : array
    {
        $data = parent::resolve( $request );

        if ( $this->includeAttachments &&
             $this->resource instanceof HasAttachmentsContract
        ) {
            $data['attachments'] = AttachmentResource::collection( $this->resource->attachments )->resolve( $request );
        }

        return $data;
    }
}
