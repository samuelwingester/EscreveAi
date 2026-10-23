<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

use App\Models\Contracts\HasAttachmentsContract;
use App\Repositories\Query\QueryOptions;

abstract class PaginatedCollection extends ResourceCollection
{
    /** @var class-string<JsonResource> */
    abstract public $collects { get; }

    public static $wrap = '';

    protected int $limit;
    protected int $offset;

    public function __construct(
        $resource,
        private int $total,
        private int $count,
        QueryOptions $options,
    ){
        parent::__construct( $resource );

        $this->limit = $options->limit;
        $this->offset = $options->offset;
    }

    /** @return array<string, mixed> */
    public function toArray( Request $request ) : array
    {
        return [
            'data'      => $this->collection,
            'total'     => $this->total,
            'count'     => $this->count,
            'limit'     => $this->limit,
            'offset'    => $this->offset,
            'links'     => [
                'next'      => $this->nextLink( $request ),
                'previous'  => $this->previousLink( $request ),
                'first'     => $this->firstLink( $request ),
                'last'      => $this->lastLink( $request ),
            ]
        ];
    }

    private function nextLink( Request $request ) : ?string
    {
        if ( $this->limit + $this->offset >= $this->total ) { return null; }

        return $request->fullUrlWithQuery([ 'offset' =>  $this->offset + $this->limit ]);
    }

    private function previousLink( Request $request ) : ?string
    {
        if ( $this->offset == 0 ) { return null; }

        return $request->fullUrlWithQuery([ 'offset' => $this->offset - $this->limit ]);
    }

    private function firstLink( Request $request ) : string
    {
        return $request->fullUrlWithQuery([ 'offset' => 0 ]);
    }

    private function lastLink( Request $request ) : string
    {
        // F = max( 0, (total - 1 // limit) * limit ) | // -> divisão inteira
        return $request->fullUrlWithQuery([ 'offset' => max( 0, intdiv( $this->total - 1, $this->limit ) * $this->limit ) ]);
    }
}
