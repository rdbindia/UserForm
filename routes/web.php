<?php

use classes\User;
use models\User as UserModel;
use services\UserService;

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

if (preg_match('/\.(?:css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|otf|eot)$/', $uri)) {
    return false;
}

$method = $_SERVER['REQUEST_METHOD'];

require_once __DIR__ . "/../app/services/UserService.php";
require_once __DIR__ . "/../app/classes/User.php";

require_once __DIR__ . "/../app/models/User.php";
$pdo = require __DIR__ . '/../config/config.php';
$userModel = new UserModel($pdo);
$userService = new UserService($userModel);

$controller = new User($userService);

$routes = [
    '' => ['controller' => $controller, 'method' => 'allUsers'],
    'create' => ['controller' => $controller, 'method' => 'create'],
    'update' => ['controller' => $controller, 'method' => 'update'],
    'delete' => ['controller' => $controller, 'method' => 'delete'],
];


if ($uri === '') {
    $routes['']['controller']->{$routes['']['method']}($_REQUEST);
    exit();
} elseif (array_key_exists($uri, $routes)) {
    $route = $routes[$uri];
    $controller = $route['controller'];
    $methodName = $route['method'];

    $controller->$methodName($_REQUEST);

    exit();
} else {
    http_response_code(404);
    echo "Page not found.";
}