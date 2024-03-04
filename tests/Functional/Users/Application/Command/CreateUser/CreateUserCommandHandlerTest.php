<?php

namespace App\Tests\Functional\Users\Application\Command\CreateUser;

use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Users\Infrastructure\Repository\UserRepository;
use App\Shared\Application\Command\CommandBusInterface;
use App\Users\Application\Command\CreateUser\CreateUserCommand;

class CreateUserCommandHandlerTest extends WebTestCase
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

    public function test_user_created_successfully(): void
    {
        $command = new CreateUserCommand(
            $this->faker->email(),
            $this->faker->password(),
            $this->faker->firstName(),
            $this->faker->lastName(),
        );

        $userUlid = $this->commandBus->execute($command);
        $user = $this->repository->findByUlid($userUlid);

        $this->assertNotEmpty($user);
    }
}