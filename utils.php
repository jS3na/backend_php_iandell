<?php

function metodoAutorizado($method, $metodosAutorizados){
    if(!in_array($method, $metodosAutorizados)){
        http_response_code(405);
        echo json_encode([
            'error' => "Método $method não autorizado"
        ]);
        exit;
    }
}

function campoObrigatorio($data, $campos){
    foreach($campos as $campo){
        if (!isset($data[$campo]) || empty($data[$campo])) {
            http_response_code(400);
            echo json_encode([
                'error' => "O campo '$campo' é obrigatório"
            ]);
            exit;
        }
    }
}