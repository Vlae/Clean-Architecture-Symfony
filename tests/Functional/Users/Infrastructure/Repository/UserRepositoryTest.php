<?php

namespace App\Tests\Functional\Users\Infrastructure\Repository;

use Faker\Factory;
use Faker\Generator;
use App\Users\Domain\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Users\Infrastructure\Repository\UserRepository;

class UserRepositoryTest extends WebTestCase
{
    private UserRepository $repository;
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = static::getContainer()->get(UserRepository::class);
        $this->faker = Factory::create();
    }

    public function test_user_added_successfully()
    {
        $email = $this->faker->email();
        $password = $this->faker->password();
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();

        $user = (new UserFactory())->create($email, $password, $firstName, $lastName);

        $this->repository->add($user);

        $existingUser = $this->repository->findByUlid($user->getUlid());
        $this->assertEquals($user->getUlid(), $existingUser->getUlid());
    }
}