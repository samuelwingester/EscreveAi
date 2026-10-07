<?php

namespace App\Repositories\Query;

use App\Repositories\Query\Contracts\QueryOptionsInterface;

class QueryOptions implements QueryOptionsInterface
{
    public string $orderBy = "id";

    public string $direction = "asc";

    public int $limit = 0;

    public int $offset = 0;

    public function __construct(
        ?int $limit = null,
        ?int $offset = null,
        ?string $orderBy = null,
        ?string $direction = null,
        ?array $options = null,
    ) {
        $this->limit     = $limit ?? $this->limit;
        $this->offset    = $offset ?? $this->offset;
        $this->orderBy   = $orderBy ?? $this->orderBy;
        $this->direction = $direction ?? $this->direction;

        if ( $options !== null ) { $this->make($options); }
    }

    private function make(array $options): void
    {
        $this->limit     = $options['limit'] ?? $this->limit;
        $this->offset    = $options['offset'] ?? $this->offset;
        $this->orderBy   = $options['order_by'] ?? $this->orderBy;
        $this->direction = $options['direction'] ?? $this->direction;
    }
}
