<?php

namespace App\Shared\Application\Query;

use App\Shared\Application\Query\QueryInterface;

interface QueryBusInterface
{
    public function execute(QueryInterface $query): mixed;
}