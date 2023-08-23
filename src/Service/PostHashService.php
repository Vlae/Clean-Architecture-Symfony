<?php

namespace App\Service;

use App\Entity\Hash;
use App\Interface\Service;
use App\Helpers\HashGenerator;
use App\Requests\PostHashRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostHashService implements Service
{
    /**
     * @var JsonResponse
     */
    private JsonResponse $response;

    /**
     * @param PostHashRequest        $request
     * @param EntityManagerInterface $em
     * @param HashGenerator          $hashGenerator
     */
    public function __construct(
        private readonly PostHashRequest        $request,
        private readonly EntityManagerInterface $em,
        private readonly HashGenerator          $hashGenerator
    ) {
        $this->response = new JsonResponse();
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $errors = $this->request->validate();
        dd($errors);
        if (count($errors) > 0) {
            $this->response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $this->response->setData((string)$errors); // todo make beaty output
            return;
        }

        $data = $this->request->getData();

        $entity = new Hash();
        $entity->setData((array)$data);
        $entity->setHash($this->hashGenerator->generateSHA1(json_encode($data)));
        $entity->setCreatedAt();

        $this->response->setStatusCode(200);
        $this->response->setData($entity->getHash());

        $this->em->persist($entity);
        $this->em->flush();

    }

    /**
     * @return JsonResponse
     */
    public function getResponse(): JsonResponse
    {
        return $this->response;
    }
}