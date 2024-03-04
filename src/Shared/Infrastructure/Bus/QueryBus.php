<?php

namespace App\Shared\Infrastructure\Bus;

use Symfony\Component\Messenger\HandleTrait;
use App\Shared\Application\Query\QueryInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class QueryBus implements QueryInterface
{
    use HandleTrait;

    /**
     * @param MessageBusInterface $queryBus
     */
    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @param QueryInterface $query
     *
     * @return mixed
     */
    public function execute(QueryInterface $query): mixed
    {
        $this->handle($query);
    }
}