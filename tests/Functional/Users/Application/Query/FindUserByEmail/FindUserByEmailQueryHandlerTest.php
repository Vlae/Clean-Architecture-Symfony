<?php

namespace App\Tests\Functional\Users\Application\Query\FindUserByEmail;

use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Users\Infrastructure\Repository\UserRepository;
use App\Shared\Application\Command\CommandBusInterface;

class FindUserByEmailQueryHandlerTest extends WebTestCase
{
    private UserRepository $repository;
    private CommandBusInterface $commandBus;
    private Generator $faker;

    /**
     * @throws \Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->repository = static::getContainer()->get(UserRepository::class);
        $this->commandBus = static::getContainer()->get(CommandBusInterface::class);
        $this->faker = Factory::create();
    }

    public function test_user_created_when_command_executed(): void
    {

    }
}