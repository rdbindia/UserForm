<?php

namespace classes;

require_once __DIR__ . '/../models/User.php';

use Exception;
use models\User as UserModel;

class User
{
    public function __construct(public readonly UserModel $userModel)
    {
    }


    /**
     * @throws Exception
     */
    public function create(array $data): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->renderForm();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = $this->userModel->createUser($data);
            echo $response->toJson();
        }
    }

    /**
     * @throws Exception
     */
    public function update(array $data): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $userId = $data['id'] ?? null;
            if (!$userId) {
                http_response_code(400);
                echo "User ID is required for updating.";
                return;
            }

            $userResponse = $this->userModel->getUserById((int)$userId);
            $userData = json_decode($userResponse->toJson(), true)['data'] ?? [];
            $this->renderForm($userData); // Render form with pre-filled data
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $data['id'] ?? null;
            if (!$userId) {
                http_response_code(400);
                echo "User ID is required for updating.";
                return;
            }

            $response = $this->userModel->updateUser((int)$userId, $data);
            echo $response->toJson();
        }
    }

    private function renderForm(?array $userData = null): void
    {
        $isUpdate = $userData !== null;
        $actionUrl = $isUpdate ? "/update?id={$userData['id']}" : "/create";

        require __DIR__ . '/../views/UserForm.php';
    }
}