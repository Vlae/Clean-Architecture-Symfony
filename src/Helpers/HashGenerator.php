<?php

namespace App\Helpers;

class HashGenerator
{
    /**
     * Note to reviewer: I guess we can add here salting string to avoid collisions.
     * But in requirements there are cases that said there will be collisions, so no salt strings added
     * In real application if this code will give to user, I prefer to make hashes unique
     *
     * @param string $data
     *
     * @return string
     */
    public function generateSHA1(string $data): string
    {
        return sha1($data);
    }
}