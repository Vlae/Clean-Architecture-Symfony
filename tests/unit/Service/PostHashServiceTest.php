<?php

namespace App\Tests\unit\Service;

use App\Helpers\HashGenerator;
use PHPUnit\Framework\TestCase;
use App\Service\PostHashService;
use App\Requests\PostHashRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class PostHashServiceTest extends TestCase
{
    private PostHashRequest $postHashRequestMock;
    private EntityManagerInterface $entityManagerMock;
    private HashGenerator $hashGeneratorMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postHashRequestMock = $this->createMock(PostHashRequest::class);
        $this->postHashRequestMock->method('validate')->willReturn(
            $this->createMock(ConstraintViolationListInterface::class)
        );

        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);

        $this->hashGeneratorMock = $this->createMock(HashGenerator::class);
        $this->hashGeneratorMock->method('generateSHA1')->willReturn('generated_hash');
    }

    public function testHandleValidData()
    {
        $this->entityManagerMock->expects($this->once())->method('persist');
        $this->entityManagerMock->expects($this->once())->method('flush');

        $service = new PostHashService(
            $this->postHashRequestMock,
            $this->entityManagerMock,
            $this->hashGeneratorMock,
        );

        $service->handle();

        $response = $service->getResponse();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(json_encode('generated_hash'), $response->getContent());
    }
}