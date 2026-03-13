<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testando criação de turma via API...\n";

$data = [
    'curso_id' => 8,
    'centro_id' => 4,
    'formador_id' => null,
    'periodo' => 'manha',
    'status' => 'planeada',
    'hora_inicio' => '08:00',
    'hora_fim' => '10:00',
    'duracao_semanas' => 8,
    'data_arranque' => '2026-04-15',
    'vagas_totais' => 25,
    'publicado' => false,
    'dia_semana' => ['Segunda', 'Quarta', 'Sexta']
];

try {
    $http = new \GuzzleHttp\Client();
    $response = $http->post('http://localhost:8000/api/turmas', [
        'json' => $data,
        'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]
    ]);

    echo "Status: " . $response->getStatusCode() . "\n";
    echo "Resposta: " . $response->getBody()->getContents() . "\n";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}