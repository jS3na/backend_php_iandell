<?php

$method = $_SERVER['REQUEST_METHOD'];

metodoAutorizado($method, ['POST']);

$data = json_decode(file_get_contents("php://input"), true);

campoObrigatorio($data, ['nome', 'email', 'senha']);

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$data['email']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user){
    http_response_code(400);
    echo json_encode([
        'error' => 'Email já utilizado!'
    ]);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
$stmt->execute([$data['nome'], $data['email'], $data['senha']]);
$userId = $pdo->lastInsertId();

echo json_encode([
    'success' => true,
    'user_id' => $userId 
]);