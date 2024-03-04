<?php

namespace App\Users\Domain\Factory;

use App\Users\Domain\Entity\User;

class UserFactory
{
    /**
     * @param string $email
     * @param string $password
     * @param string $firstname
     * @param string $lastname
     *
     * @return User
     */
    public function create(string $email, string $password, string $firstname, string $lastname): User
    {
        return new User($email, $password, $firstname, $lastname);
    }
}