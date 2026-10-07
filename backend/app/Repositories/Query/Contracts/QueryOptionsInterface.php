<?php
// Talvez desnecessario, quase toda certeza pra falar a verdade mas o gleison entra na minha cabeça
namespace App\Repositories\Query\Contracts;

interface QueryOptionsInterface
{
    public string $orderBy { get; set; }

    public string $direction { get; set; }

    public int $limit { get; set; }

    public int $offset { get; set; }
}
