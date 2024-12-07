<?php

namespace database\seeders;

use database\factories\UserFactory;
use PDO;

class UserSeeder
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function seed(int $count = 10): void
    {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("
                INSERT INTO users (first_name,last_name, email, mobile_number, address, city, state, zip)
                VALUES (:first_name,:last_name, :email, :mobile_number, :address, :city, :state, :zip)
            ");

            for ($i = 0; $i < $count; $i++) {
                $data = UserFactory::create();
                $stmt->execute([
                    ':first_name' => $data['first_name'],
                    ':last_name' => $data['last_name'],
                    ':email' => $data['email'],
                    ':mobile_number' => $data['mobile_number'],
                    ':address' => $data['address'],
                    ':city' => $data['city'],
                    ':state' => $data['state'],
                    ':zip' => $data['zip'],
                ]);
            }

            $this->pdo->commit();
            echo "Successfully seeded {$count} users.\n";
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            echo "Seeding failed: " . $e->getMessage() . "\n";
        }
    }
}