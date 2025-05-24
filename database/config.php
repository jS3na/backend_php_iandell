<?php 

//credenciais do banco de dados mysql
$host = 'localhost';
$db = 'app';
$user = 'root';
$password = 'senha123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password); //cria uma nova conexao com o bd usando as credenciais
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //só pra se ocorrer algum erro, jogar no catch
} catch (PDOException $e) { //se a conexão tiver algum erro
    http_response_code(500);
    echo json_encode(['error' => 'erro no bd']);
    exit();
}