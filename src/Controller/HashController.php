<?php

namespace App\Controller;

use OpenApi\Attributes\Tag;
use OpenApi\Attributes\Schema;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Parameter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HashController extends AbstractController
{
    #[Route('/api/hash', name: 'hash', methods: ['POST'])]
    #[Response(
        response: 200,
        description: 'Creates md1 hash based on data',

    )]
    #[Parameter(
        name: 'data',
        schema: new Schema(type: 'string')
    )]
    #[Tag('hash')]
    public function hash()
    {
        return new JsonResponse(['data' => 'anything'], 200);
    }

    #[Route('/api/hash/{hash}', name: 'getHash', methods: ['GET'])]
    #[Response(
        response: 200,
        description: 'Retrieve data based',

    )]
    #[Tag('hash')]
    public function getHash()
    {

    }


}