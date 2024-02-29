<?php

namespace App\Shared\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController
{
    #[Route('/api/health', name: 'health_check', methods: ['GET'])]
    #[\OpenApi\Attributes\Response(
        response: 200,
        description: 'Checks is server alive',
    )]
    public function index(): JsonResponse
    {
        $data = ['message' => 'API health check is done'];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}