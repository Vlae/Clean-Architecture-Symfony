<?php

namespace App\Users\Domain\Entity;

use App\Shared\Application\Service\UlidService;

class User
{
    private string $ulid;
    private string $email;
    private string $password;
    private string $first_name;
    private string $last_name;

    /**
     * @param string $email
     * @param string $password
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(string $email, string $password, string $firstName, string $lastName)
    {
        $this->ulid = UlidService::generate();
        $this->email = $email;
        $this->password = $password;
        $this->first_name = $firstName;
        $this->last_name = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getUlid(): string
    {
        return $this->ulid;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }
}