<?php

// Teste simples para verificar se /cursos retorna JSON
$url = 'http://127.0.0.1:8000/cursos';

// Fazer requisição com header Accept: application/json
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => "Accept: application/json\r\nX-Requested-With: XMLHttpRequest\r\n"
    ]
]);

$response = @file_get_contents($url, false, $context);

if ($response === false) {
    echo "ERRO: Não foi possível acessar a URL\n";
    exit(1);
}

echo "=== Resposta da rota /cursos ===\n";
echo "Status: " . (strpos($http_response_header[0], '200') !== false ? 'OK (200)' : 'ERRO') . "\n";
echo "\n=== Headers ===\n";
foreach ($http_response_header as $header) {
    if (strpos($header, 'Content-Type') !== false) {
        echo $header . "\n";
    }
}

echo "\n=== Primeiras 500 caracteres ===\n";
echo substr($response, 0, 500) . "\n";

// Tenta fazer parse como JSON
$decoded = json_decode($response, true);
if ($decoded === null) {
    echo "\n❌ ERRO: Resposta não é JSON válido\n";
    echo "Primeiros 1000 caracteres da resposta:\n";
    echo substr($response, 0, 1000) . "\n";
} else {
    echo "\n✓ Resposta é JSON válido\n";
    echo "Número de cursos: " . count($decoded) . "\n";
    if (count($decoded) > 0 && isset($decoded[0]['id'])) {
        echo "Primeira entrada encontrada: ID=" . $decoded[0]['id'] . ", Nome=" . $decoded[0]['nome'] . "\n";
    }
}
?>
