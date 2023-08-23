<?php

namespace App\Service;

use App\Entity\Hash;
use App\Interface\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetHashService implements Service
{
    /**
     * @var JsonResponse
     */
    private JsonResponse $response;

    /**
     * @param EntityManagerInterface $em
     * @param string                 $hash
     */
    public function __construct(
        private readonly EntityManagerInterface $em,
        private string $hash,
    ) {
        $this->response = new JsonResponse('Nothing was found',  Response::HTTP_NOT_FOUND);
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $rows = $this->em->getRepository(Hash::class)->findBy(['hash' => $this->hash]);

        if (empty($rows)) {
            return;
        }

        $entity = current($rows);
        $responseData['item'] = $entity->getData();

        if (count($rows) > 1) {
            /** @var Hash $hashEntity */
            foreach ($rows as $hashEntity) {
                $responseData['collisions'][] = [
                    'object' => $hashEntity->getData(),
                    'created_at' => $hashEntity->getCreatedAt()->format('Y-m-d H:i:s'), // Want to give something that would be show that row is unique, but don't want to give ID becasue it's gives access to DB important data
                ];
            }
            $this->response = new JsonResponse($responseData, Response::HTTP_OK);
        } elseif (count($rows) === 1) {
            $this->response = new JsonResponse($responseData, Response::HTTP_OK);
        }
    }

    /**
     * @param string $hash
     *
     * @return void
     */
    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    /**
     * @return JsonResponse
     */
    public function getResponse(): JsonResponse
    {
        return $this->response;
    }
}