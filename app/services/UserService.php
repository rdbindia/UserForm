<?php

namespace services;

require_once __DIR__ . '/UserServiceInterface.php';

use Exception;
use helpers\JsonResponse;
use models\User as UserModel;

class UserService implements UserServiceInterface
{

    public function __construct(public readonly UserModel $userModel)
    {

    }

    /**
     * @throws \Exception
     */
    public function create(array $data): JsonResponse
    {
        try {
            $this->validate($data);
            $data['created_at'] = date('Y-m-d H:i:s');
            $success = $this->userModel->createUser($data);
            if ($success) {
                return JsonResponse::response(['success' => true, 'message' => 'User created successfully.']);
            }
            return JsonResponse::response(['success' => false, 'error' => 'Failed to create user.'], 500);
        } catch (Exception $e) {
            return JsonResponse::response(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }

    public function update(int $id, array $data): JsonResponse
    {
        try {
            $existingUser = $this->userModel->getUserById($id);

            if (!$existingUser) {
                return JsonResponse::response(['success' => false, 'error' => 'User not found.'], 404);
            }

            $this->validate($data);

            $success = $this->userModel->updateUser($id, $data);

            if ($success) {
                return JsonResponse::response(['success' => true, 'message' => 'User updated successfully.']);
            }

            return JsonResponse::response(['success' => false, 'error' => 'Failed to update user.'], 500);

        } catch (\Exception $e) {
            return JsonResponse::response(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }

    public function delete(int $id): JsonResponse
    {
        $existingUser = $this->userModel->getUserById($id);

        if (!$existingUser) {
            return JsonResponse::response(['success' => false, 'error' => 'User not found.'], 404);
        }

        $success = $this->userModel->deleteUser($id);

        if ($success) {
            return JsonResponse::response(['success' => true, 'message' => 'User deleted successfully.']);
        }

        return JsonResponse::response(['success' => false, 'error' => 'Failed to delete user.'], 500);
    }

    public function getUserById(int $id): JsonResponse
    {
        $userData = $this->userModel->getUserById($id);

        if (!$userData) {
            return JsonResponse::response(['success' => false, 'error' => 'User not found.'], 404);
        }

        return JsonResponse::response(['success' => true, 'data' => $userData]);
    }

    public function getAllUsers(): JsonResponse
    {
        return $this->userModel->getAllUsers();
    }

    /**
     * @throws Exception
     */
    private function validate(array $data): void
    {
        if (empty($data['first_name'])) {
            throw new Exception("First Name is required.");
        }

        if (empty($data['last_name'])) {
            throw new Exception("Last Name is required.");
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address.");
        }

        if (!is_null($data['mobile_number']) && strlen($data['mobile_number']) > 10) {
            throw new Exception("Mobile Number must be exactly 10 digits.");
        }

        if (!is_null($data['address']) && strlen($data['address']) > 255) {
            throw new Exception("Address must not exceed 255 characters.");
        }

        if ($data['city'] && strlen($data['address']) > 128) {
            throw new Exception("Invalid city.");
        }

        if (!is_null($data['state']) && strlen($data['state']) !== 2) {
            throw new Exception("State must be exactly 2 characters.");
        }

        if (!is_null($data['zip']) && !is_numeric($data['zip'])) {
            throw new Exception("ZIP code must be numeric.");
        }
    }
}