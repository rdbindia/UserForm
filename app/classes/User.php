<?php

namespace classes;

require_once __DIR__ . '/../models/User.php';

use Exception;
use helpers\JsonResponse;
use services\UserServiceInterface;

class User
{
    public function __construct(public readonly UserServiceInterface $userService)
    {
    }

    /**
     * @throws Exception
     */
    public function create(array $data): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = $this->userService->create($data);
            echo $response->toJson();
        } else {
            $this->renderForm();
        }
    }

    /**
     * @throws Exception
     */
    public function update(array $data): void
    {
        $id = $data['id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $userResponse = $this->userService->getUserById($id);
            $userData = json_decode($userResponse->toJson(), true)['data'] ?? [];

            if (!$userData) {
                http_response_code(404);
                require __DIR__ . '/../views/error.php';
                return;
            }

            $this->renderForm($userData);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $this->userService->update($id, $data)->toJson();
        }
    }

    public function delete(array $data): void
    {
        $userId = $data['id'] ?? null;

        if (!$userId) {
            http_response_code(400);
            echo JsonResponse::response(['error' => 'User ID is required for deletion.'], 400)->toJson();
            return;
        }

        $response = $this->userService->delete($userId);
        echo $response->toJson();
    }

    public function allUsers(): void
    {
        $response = $this->userService->getAllUsers();
        $users = json_decode($response->toJson(), true)['data'] ?? [];

        require __DIR__ . '/../views/index.php';
    }

    private function renderForm(?array $userData = null): void
    {
        $isUpdate = $userData !== null;
        $actionUrl = $isUpdate ? "/update" : "/create";

        require __DIR__ . '/../views/UserForm.php';
    }
}