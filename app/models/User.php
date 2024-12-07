<?php

namespace models;

require_once __DIR__ . '/../helpers/JsonResponse.php';

use Exception;
use helpers\JsonResponse;
use PDO;
use PDOException;

class User
{
    private array $properties = [
        'id' => null,
        'first_name' => null,
        'last_name' => null,
        'email' => null,
        'mobile_number' => null,
        'address' => null,
        'city' => null,
        'state' => null,
        'zip' => null,
        'created_at' => null,
        'updated_at' => null,
    ];

    public function __construct(public readonly PDO $pdo)
    {
    }

    /**
     * @throws Exception
     */
    public function createUser(array $data): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO users (first_name, last_name, email, mobile_number, address, city, state, zip)
            VALUES (:first_name, :last_name, :email, :mobile_number, :address, :city, :state, :zip)
        ");

        return $stmt->execute([
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':email' => $data['email'],
            ':mobile_number' => $data['mobile_number'] ?? null,
            ':address' => $data['address'] ?? null,
            ':city' => $data['city'] ?? null,
            ':state' => $data['state'] ?? null,
            ':zip' => $data['zip'] ?? null,
        ]);
    }

    public function getUserById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * @throws Exception
     */
    public function updateUser(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE users
            SET first_name = :first_name, 
                last_name = :last_name, 
                email = :email, 
                mobile_number = :mobile_number, 
                address = :address, 
                city = :city, 
                state = :state, 
                zip = :zip
            WHERE id = :id
        ");
        return $stmt->execute([':id' => $id] + $data);
    }

    public function deleteUser(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function toArray(): array
    {
        return $this->properties;
    }

    public function get(string $property): mixed
    {
        return $this->properties[$property] ?? null;
    }

    public function setProperties(array $data): void
    {
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $this->properties)) {
                $this->properties[$key] = $value;
            }
        }
    }

    public function set(string $property, $value): void
    {
        if (array_key_exists($property, $this->properties)) {
            $this->properties[$property] = $value;
        }
    }

    public function getAllUsers(): JsonResponse
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM users");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return JsonResponse::response(['success' => true, 'data' => $users]);
        } catch (PDOException $e) {
            return JsonResponse::response(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}