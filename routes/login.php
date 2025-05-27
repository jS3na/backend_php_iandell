<?php

$method = $_SERVER['REQUEST_METHOD'];

metodoAutorizado($method, ['POST']);

$data = json_decode(file_get_contents("php://input"), true);

campoObrigatorio($data, ['email', 'senha']);

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$data['email']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user && $user['senha'] === $data['senha']){
    echo json_encode([
        'success' => true,
        'id_usuario' => $user['id'],
    ]);
    exit;
}

http_response_code(401);
echo json_encode([
    'error' => 'Email ou senha incorretos'
]);
exit;