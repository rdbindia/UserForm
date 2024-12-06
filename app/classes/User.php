<?php

namespace classes;
require_once __DIR__ . '/../models/User.php';
use models\User as UserModel;

class User
{
    private UserModel $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    public function create($data) {
        var_dump($data);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->createUser($data);
            header('Location: /');
        } else {
            require __DIR__ . '/../views/user/form.php';
        }
    }

    public function edit($data) {
        $user = $this->model->getUserById($data['id']);
        require __DIR__ . '/../views/user/form.php';
    }

    public function update($data) {
        $this->model->updateUser($data['id'], $data);
        header('Location: /');
    }

    public function delete($data) {
        $this->model->deleteUser($data['id']);
        header('Location: /');
    }
}