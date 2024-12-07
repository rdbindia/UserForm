<?php

require_once __DIR__ . '/../../app/services/UserService.php';

use helpers\JsonResponse;
use models\User;
use PHPUnit\Framework\TestCase;
use services\UserService;

class UserServiceTest extends TestCase
{
    public function testCreateUserCallsModel(): void
    {
        $userMock = $this->createMock(User::class);

        $userMock->expects($this->once())
            ->method('createUser')
            ->willReturn(new JsonResponse(['success' => true]));

        $service = new UserService($userMock);
        $response = $service->create(['first_name' => 'John', 'email' => 'john@example.com']);

        $this->assertTrue($response->toArray()['success']);
    }
}