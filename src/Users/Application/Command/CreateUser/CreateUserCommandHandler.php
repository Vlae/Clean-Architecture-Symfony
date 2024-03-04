<?php

namespace App\Users\Application\Command\CreateUser;

use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }


    /**
     * @param CreateUserCommand $createUserCommand
     *
     * @return string userId
     */
    public function __invoke(CreateUserCommand $createUserCommand): string
    {
        $user = (new UserFactory())->create(
            $createUserCommand->email,
            $createUserCommand->password,
            $createUserCommand->firstName,
            $createUserCommand->lastName
        );

        $this->userRepository->add($user);

        return $user->getUlid();
    }
}