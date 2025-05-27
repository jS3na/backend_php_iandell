<?php

$method = $_SERVER['REQUEST_METHOD'];

metodoAutorizado($method, ['GET']);

$stmt = $pdo->prepare("SELECT * FROM categorias");
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    'categorias' => $categorias
]);
