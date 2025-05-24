<?php

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'POST') {
    http_response_code(405);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if(!isset($data['name']) || !isset($data['email']) || !isset($data['password'])){
    http_response_code(400);
    echo json_encode(['error' => 'Preencha os campos obrigatórios']);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->execute([$data['name'], $data['email'], $data['password']]);
$userId = $pdo->lastInsertId();

echo json_encode(['success' => true, 'user_id' => $userId]);