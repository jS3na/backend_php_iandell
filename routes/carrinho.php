<?php

$method = $_SERVER['REQUEST_METHOD'];

metodoAutorizado($method, ['GET', 'POST', 'DELETE']);

$requestUri = explode("/", $_SERVER['REQUEST_URI']);
$id = end($requestUri);

if (!is_numeric($id)) {
    http_response_code(400);
    echo json_encode(["error" => "ID inválido."]);
    exit;
}

switch ($method) {
    case 'GET':
        $stmt = $pdo->prepare("SELECT 
                                        carrinho.id AS id,
                                        carrinho.id_produto,
                                        carrinho.id_usuario,
                                        carrinho.quantidade,
                                        produtos.nome,
                                        produtos.descricao,
                                        produtos.imagem_url,
                                        produtos.preco,
                                        produtos.estoque,
                                        produtos.id_categoria
                                        FROM carrinho
                                        INNER JOIN produtos 
                                        ON carrinho.id_produto = produtos.id
                                        WHERE carrinho.id_usuario = ?");
        $stmt->execute([$id]);
        $carrinho = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode([
            'success' => 'true',
            'carrinho' => $carrinho
        ]);
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        campoObrigatorio($data, ['id_produto', 'quantidade']);

        $stmt = $pdo->prepare("SELECT * FROM carrinho WHERE id_produto = ? AND id_usuario = ?");
        $stmt->execute([$data['id_produto'], $id]);
        $carrinho = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($carrinho) {
            $soma = $data['quantidade'] + $carrinho['quantidade'];
            $stmt = $pdo->prepare("UPDATE carrinho SET quantidade = ? WHERE id = ?");
            $stmt->execute([$soma, $carrinho['id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO carrinho (id_produto, id_usuario, quantidade)
                                            VALUES (?, ?, ?)");
            $stmt->execute([$data['id_produto'], $id, $data['quantidade']]);
        }

        echo json_encode([
            'success' => 'true',
        ]);
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        campoObrigatorio($data, ["id_carrinho"]);

        $stmt = $pdo->prepare("SELECT * FROM carrinho WHERE id = ? AND id_usuario = ?");
        $stmt->execute([$data["id_carrinho"], $id]);
        $carrinho = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($carrinho) {
            $stmt = $pdo->prepare("DELETE FROM carrinho WHERE id = ? AND id_usuario = ?");
            $stmt->execute([$data["id_carrinho"], intval($id)]);

            echo json_encode([
                'success' => true
            ]);
            exit;
        }

        echo json_encode([
            'error' => 'Carrinho não encontrado'
        ]);

}