<?php

namespace services;

require_once __DIR__ . '/UserServiceInterface.php';

use helpers\JsonResponse;
use models\User as UserModel;

class UserService implements UserServiceInterface
{

    public function __construct(public readonly UserModel $userModel)
    {

    }

    public function create(array $data): JsonResponse
    {
        try {
            $this->userModel->setProperties($data);
            $this->userModel->validate();

            return $this->userModel->createUser($data);
        } catch (\Exception $e) {
            return JsonResponse::response(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }

    public function update(int $id, array $data): JsonResponse
    {
        try {
            $this->userModel->setProperties($data);
            $this->userModel->validate();

            return $this->userModel->updateUser($id, $data);
        } catch (\Exception $e) {
            return JsonResponse::response(['success' => false, 'error' => $e->getMessage()], 400);
        }    }

    public function delete(int $id): JsonResponse
    {
        return $this->userModel->deleteUser($id);
    }

    public function getUserById(int $id): JsonResponse
    {
        return $this->userModel->getUserById($id);
    }

    public function getAllUsers(): JsonResponse
    {
        return $this->userModel->getAllUsers();
    }
}