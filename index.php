<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

use App\Config\Container;
use App\Config\DB;
use App\Core\Http\Request;
use App\Core\Http\Router;

require_once __DIR__ . '/vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$container = Container::getInstance();
$container->bind(\PDO::class, DB::getConnection());
$container->bind(Request::class, new Request());

$router = new Router();

require_once __DIR__ . '/routes.config.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($method === 'PUT' && preg_match('#^/users/(\d+)$#', $uri, $matches)) {
    $userId = $matches[1];
    handleEditUser($userId);
    exit;
}

$router->dispatch($method, $uri);




