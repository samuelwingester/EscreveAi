<?php

namespace App\Repositories\Query;

/**
 * TO DO
 * - Mudar o arquivo de lugar, não faz sentido estar aqui
 */

class QueryOptions {
    public string $orderBy;
    public string $direction;
    public int $limit;
    public int $offset;

    public function __construct(array $options)
    {
        $this->limit = max(1, (int) ($options['limit'] ?? 20));
        $this->offset = max(0, (int) ($options['offset'] ?? 0));
        $this->orderBy = $options['order_by'] ?? 'id';
        $this->direction = $options['direction'] ?? 'asc' === 'desc' ? 'desc' : 'asc';
    }
}
