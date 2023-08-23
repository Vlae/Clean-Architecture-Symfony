<?php

namespace App\Interface;

use Symfony\Component\HttpFoundation\JsonResponse;

interface Service
{
    public function getResponse(): JsonResponse;

    public function handle();
}