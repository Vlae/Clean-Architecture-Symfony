<?php

namespace App\Users\Infrastructure\Repository;

use Psr\Log\LoggerInterface;
use App\Users\Domain\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    /**
     * @param ManagerRegistry $registry
     * @param LoggerInterface $logger
     */
    public function __construct(ManagerRegistry $registry, private readonly LoggerInterface $logger)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function add(User $user): void
    {
        try {
            $this->_em->persist($user);
            $this->_em->flush();
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
        }
    }

    /**
     * @param string $ulid
     *
     * @return User
     */
    public function findByUlid(string $ulid): User
    {
        return $this->find($ulid);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }
}