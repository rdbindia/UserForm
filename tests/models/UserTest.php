<?php

namespace models;

require_once __DIR__ . '/../../app/models/User.php';


use PDO;
use PDOStatement;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;


class UserTest extends TestCase
{
    private MockObject|PDO $pdoMock;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $this->pdoMock = $this->createMock(PDO::class);

        $this->pdoMock
            ->method('prepare')
            ->willReturn($this->createMock(PDOStatement::class));
    }

    public function testCreateUser(): void
    {
        $user = new User($this->pdoMock);

        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'mobile_number' => '1234567890',
            'address' => '123 Main St',
            'city' => 'New York',
            'state' => 'NY',
            'zip' => '10001'
        ];

        $response = $user->createUser($data);
        $this->assertTrue($response->toArray()['success']);
    }

}