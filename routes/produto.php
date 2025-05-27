<?php

$method = $_SERVER['REQUEST_METHOD'];

metodoAutorizado($method, ['GET']);

$requestUri = explode("/", $_SERVER['REQUEST_URI']);
$id = end($requestUri);

if(is_numeric($id)){
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'produto' => $produto
    ]);
    exit;
}

$stmt = $pdo->prepare("
    SELECT 
        produtos.*, 
        categorias.nome AS categoria_nome,
        categorias.id AS categoria_id
    FROM produtos
    INNER JOIN categorias ON produtos.id_categoria = categorias.id
");
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$agrupadoPorCategoria = [];

foreach ($produtos as $produto) {
    $categoria = $produto['categoria_nome'];

    if (!isset($agrupadoPorCategoria[$categoria])) {
        $agrupadoPorCategoria[$categoria] = [];
    }

    unset($produto['categoria_nome'], $produto['categoria_id']);

    $agrupadoPorCategoria[$categoria][] = $produto;
}

echo json_encode([
    'success' => true,
    'produtos' => $agrupadoPorCategoria
]);