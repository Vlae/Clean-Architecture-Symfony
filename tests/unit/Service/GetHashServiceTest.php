<?php

namespace App\Tests\unit\Service;

use App\Entity\Hash;
use PHPUnit\Framework\TestCase;
use App\Service\GetHashService;
use App\Repository\HashRepository;
use Doctrine\ORM\EntityManagerInterface;

class GetHashServiceTest extends TestCase
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $emMock;

    /**
     * @var HashRepository
     */
    private HashRepository $hashRepositoryMock;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->emMock = $this->createMock(EntityManagerInterface::class);
        $this->hashRepositoryMock = $this->createMock(HashRepository::class);
        $this->emMock->method('getRepository')->willReturn($this->hashRepositoryMock);
    }

    /**
     * @return void
     */
    public function testHandleWithNoRows()
    {
        $getHashService = new GetHashService($this->emMock, 'some_hash');
        $this->hashRepositoryMock->method('findBy')->willReturn([]);

        $getHashService->handle();

        $this->assertEquals(json_encode('Nothing was found'), $getHashService->getResponse()->getContent());
        $this->assertEquals(404, $getHashService->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider provideOneRowData
     */
    public function testHandleWithOneRow($findByResult, $responseDataOutput)
    {
        $getHashService = new GetHashService($this->emMock, 'some_hash');
        $this->hashRepositoryMock->method('findBy')->willReturn($findByResult);
        $getHashService->handle();


        $this->assertEquals(200, $getHashService->getResponse()->getStatusCode());
        $this->assertEquals($responseDataOutput, $getHashService->getResponse()->getContent());
    }

    /**
     * @dataProvider provideMultipleRowData
     */
    public function testHandleWithMultipleRows($findByResult, $responseDataOutput)
    {
        $getHashService = new GetHashService($this->emMock, 'some_hash');
        $this->hashRepositoryMock->method('findBy')->willReturn($findByResult);
        $getHashService->handle();

        $this->assertEquals(200, $getHashService->getResponse()->getStatusCode());
        $this->assertEquals(current($responseDataOutput), $getHashService->getResponse()->getContent());
    }




    /**
     * @return array[]
     */
    public function provideOneRowData()
    {
        return [
            'plain_text' => [
                [(new Hash())->setData(['anything'])], // findBy result,
                json_encode(['item' => ['anything']])  // expected responseData output
            ],
            'json_object' => [
                [
                    (new Hash())->setData([
                        'user' => 'test_user',
                        'password' => '6521'
                    ])
                ],
                json_encode([
                    'item' => [
                        'user' => 'test_user',
                        'password' => '6521'
                    ]
                ])
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function provideMultipleRowData()
    {
        return [
            'findByMultiple' => [
                [
                    (new Hash)
                        ->setData(['test'])
                        ->setCreatedAt(),
                    (new Hash)
                        ->setData(['test'])
                        ->setCreatedAt(),
                    (new Hash)
                        ->setData(['test'])
                        ->setCreatedAt(),
                ],
                [
                    json_encode(
                        [
                            'item' => ['test'],
                            'collisions' => [
                                [
                                    'object' => ['test'],
                                    'created_at' => date('Y-m-d H:i:s'),
                                ],
                                [
                                    'object' => ['test'],
                                    'created_at' => date('Y-m-d H:i:s'),
                                ],
                                [
                                    'object' => ['test'],
                                    'created_at' => date('Y-m-d H:i:s'),
                                ],
                            ]
                        ]
                    )
                ]
            ]
        ];
    }
}