<?php

$host = 'localhost';
$bancoDeDados = 'app';
$usuario = 'root';
$senha = 'senha123';

try{
    $pdo = new PDO("mysql:host=$host;dbname=$bancoDeDados;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    exit();
}