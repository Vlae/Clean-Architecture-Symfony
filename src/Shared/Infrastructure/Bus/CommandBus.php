<?php

namespace App\Shared\Infrastructure\Bus;

use Symfony\Component\Messenger\HandleTrait;
use App\Shared\Application\Command\CommandInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Shared\Application\Command\CommandBusInterface;

class CommandBus implements CommandBusInterface
{
    use HandleTrait;

    /**
     * @param MessageBusInterface $commandBus
     */
    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    /**
     * @param CommandInterface $command
     *
     * @return mixed
     */
    public function execute(CommandInterface $command): mixed
    {
        return $this->handle($command);
    }
}