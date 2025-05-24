<?php

require 'database/config.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$uri = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

$resource = $uri[0] ?? null;

switch ($resource) {
    case null:
        echo json_encode(['message' => 'raiz']);
        break;
    case 'auth':
        require './routes/auth.php';
        break;
    case 'register':
        require './routes/register.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Rota não encontrada']);
        break;
}
