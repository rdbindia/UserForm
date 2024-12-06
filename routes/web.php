<?php

require_once __DIR__ . '/../config/config.php';


$routes = [
    '' => ['controller' => 'null', 'method' => 'index'],
    'create' => ['controller' => 'User', 'method' => 'create'],
    'edit' => ['controller' => 'User', 'method' => 'edit'],
    'update' => ['controller' => 'User', 'method' => 'update'],
    'delete' => ['controller' => 'User', 'method' => 'delete'],
];

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '') {
    require_once __DIR__ . '/../index.php';
}
elseif (array_key_exists($uri, $routes)) {
    $route = $routes[$uri];

    $controllerName = $route['controller'];
    require_once __DIR__ . "/../app/classes/{$controllerName}.php";

    $controllerClass = "classes\\$controllerName";
    $methodName = $route['method'];



    $controller = new $controllerClass();

    if (!method_exists($controller, $methodName)) {
        echo "Method $methodName does not exist in $controllerName!";
        exit;
    }
    $controller->$methodName($_REQUEST);
} else {
    http_response_code(404);
    echo "Page not found.";
}