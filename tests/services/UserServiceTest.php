<?php

require_once __DIR__ . '/../../app/services/UserService.php';

use models\User;
use PHPUnit\Framework\TestCase;
use services\UserService;

class UserServiceTest extends TestCase
{
    protected function setUp(): void
    {
        $this->userMock = $this->createMock(User::class);

        $this->userMock->method('createUser')
            ->willReturn(true);

        $this->userService = new UserService($this->userMock);
    }

    public function testCreateUserModel(): void
    {
        $this->userMock->expects($this->once())
            ->method('createUser')
            ->with($this->callback(function ($data) {
                return isset($data['first_name'], $data['last_name'], $data['email']);
            }));

        $response = $this->userService->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'mobile_number' => '0123456789',
            'address' => '123 Some Street',
            'city' => 'Some City',
            'state' => 'CA',
            'zip' => '12345',
        ]);

        $this->assertTrue($response->toArray()['success']);
    }
}