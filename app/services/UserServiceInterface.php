<?php

namespace services;

use helpers\JsonResponse;

interface UserServiceInterface
{
    public function create(array $data): JsonResponse;

    public function update(int $id, array $data): JsonResponse;

    public function delete(int $id): JsonResponse;
}