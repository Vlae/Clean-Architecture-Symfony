<?php

namespace App\Tests\Resource\Fixture;

use App\Tests\Tools\FakerTools;
use Doctrine\Persistence\ObjectManager;
use App\Users\Domain\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixture extends Fixture
{
    use FakerTools;

    const REFERENCE = 'user';

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $email = $this->getFaker()->email();
        $password = $this->getFaker()->password();
        $firstName = $this->getFaker()->firstName();
        $lastName = $this->getFaker()->lastName();

        $user = (new UserFactory())->create($email, $password, $firstName, $lastName);

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::REFERENCE, $user);
    }
}