<?php 

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'POST') {
    http_response_code(405);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if(!isset($data['email']) || !isset($data['password'])){
    http_response_code(400);
    echo json_encode(['error' => 'Preencha os campos obrigatórios']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$data['email']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user && $data['password'] == $user['password']){
    echo json_encode(['success' => true, 'user_id' => $user['id']]);
}
else{
    echo json_encode(['success' => false]);
}
