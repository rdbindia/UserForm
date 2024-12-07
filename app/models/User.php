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
    public function createUser(array $data): JsonResponse
    {
        try {
            $this->setProperties($data);
            $this->validate();

            $stmt = $this->pdo->prepare("
            INSERT INTO users (first_name,last_name, email, mobile_number, address, city, state, zip)
            VALUES (:first_name,:last_name, :email, :mobile_number, :address, :city, :state, :zip)
        ");

            $stmt->execute([
                ':first_name' => $data['first_name'],
                ':last_name' => $data['last_name'],
                ':email' => $data['email'],
                ':mobile_number' => $data['mobile_number'] ?? null,
                ':address' => $data['address'] ?? null,
                ':city' => $data['city'] ?? null,
                ':state' => $data['state'] ?? null,
                ':zip' => $data['zip'] ?? null,
            ]);

            return JsonResponse::response(['success' => true, 'message' => 'User created successfully.']);
        } catch (Exception $e) {
            return JsonResponse::response(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function getUserById(int $id): ?JsonResponse
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                return JsonResponse::response(['success' => false, 'message' => 'User not found.']);
            }

            $this->setProperties($result);
            return JsonResponse::response(['success' => true, 'data' => $this->toArray()]);

        } catch (Exception $e) {
            return JsonResponse::response(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @throws Exception
     */
    public function updateUser($id, $data): JsonResponse
    {
        try {
            $this->setProperties($data);
            $this->validate();

            $stmt = $this->pdo->prepare("
                UPDATE users
                SET first_name = :first_name,last_name = :last_name, email = :email, mobile_number = :mobile_number,
                    address = :address, city = :city, state = :state, zip = :zip
                WHERE id = :id
            ");

            $stmt->execute([
                ':id' => $id,
                ':first_name' => $data['first_name'],
                ':last_name' => $data['last_name'],
                ':email' => $data['email'],
                ':mobile_number' => $data['mobile_number'] ?? null,
                ':address' => $data['address'] ?? null,
                ':city' => $data['city'] ?? null,
                ':state' => $data['state'] ?? null,
                ':zip' => $data['zip'] ?? null,
            ]);

            return JsonResponse::response(['success' => true, 'data' => $this->toArray()]);

        } catch (PDOException $e) {
            return JsonResponse::response(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }

    public function deleteUser(int $id): JsonResponse
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute([':id' => $id]);

            if ($stmt->rowCount() === 0) {
                return JsonResponse::response(['success' => false, 'message' => 'User not found.']);
            }

            return JsonResponse::response(['success' => true, 'message' => 'User deleted successfully.']);
        } catch (Exception $e) {
            return JsonResponse::response(['success' => false, 'error' => $e->getMessage()]);
        }
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

    /**
     * @throws Exception
     */
    public function validate(): void
    {
        if (empty($this->properties['first_name'])) {
            throw new Exception("First Name is required.");
        }

        if (empty($this->properties['last_name'])) {
            throw new Exception("Last Name is required.");
        }

        if (!filter_var($this->properties['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address.");
        }

        if (!is_null($this->properties['mobile_number']) && !preg_match('/^\d{10}$/', $this->properties['mobile_number'])) {
            throw new Exception("Mobile Number must be exactly 10 digits.");
        }

        if (!is_null($this->properties['address']) && strlen($this->properties['address']) > 255) {
            throw new Exception("Address must not exceed 255 characters.");
        }

        if ($this->properties['city'] && strlen($this->properties['address']) > 128) {
            throw new Exception("Invalid city.");
        }

        if (!is_null($this->properties['state']) && strlen($this->properties['state']) !== 2) {
            throw new Exception("State must be exactly 2 characters.");
        }

        if (!is_null($this->properties['zip']) && !is_numeric($this->properties['zip'])) {
            throw new Exception("ZIP code must be numeric.");
        }
    }
}