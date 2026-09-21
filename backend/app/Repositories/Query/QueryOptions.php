<?php

namespace App\Repositories\Query;

use App\Repositories\Query\Contracts\QueryOptionsInterface;

class QueryOptions implements QueryOptionsInterface
{
    public string $orderBy = "id";

    public string $direction = "asc";

    public int $limit = 0;

    public int $offset = 0;

    public function __construct() {} // os atributos devem ser atribuidos manualmente nos services
}
