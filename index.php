<?php

include('database/config.php');
include('utils.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$uri = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

$request = $uri[0] ?? null;

switch ($request) {
    case 'login':
        include('routes/login.php');
        break;
    case 'cadastro':
        include('routes/cadastro.php');
        break;
    case 'categoria':
        include('routes/categoria.php');
        break;
    case 'produto':
        include('routes/produto.php');
        break;
    case 'carrinho':
        include('routes/carrinho.php');
        break;
    default:
        echo json_encode([
            'message' => 'Rota inexistente'
        ]);
        break;
}