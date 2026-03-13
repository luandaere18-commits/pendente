<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Criando usuário admin...\n";

$user = App\Models\User::firstOrCreate(
    ['email' => 'admin@test.com'],
    [
        'name' => 'Admin',
        'password' => bcrypt('123456'),
        'is_admin' => true
    ]
);

echo "Usuário criado: " . $user->email . " - ID: " . $user->id . "\n";

// Fazer login e obter token
$credentials = [
    'email' => 'admin@test.com',
    'password' => '123456'
];

try {
    $http = new \GuzzleHttp\Client();
    $response = $http->post('http://localhost:8000/api/login', [
        'json' => $credentials,
        'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]
    ]);

    $data = json_decode($response->getBody()->getContents(), true);
    echo "Login realizado. Token: " . ($data['token'] ?? 'N/A') . "\n";

    if (isset($data['token'])) {
        // Testar criação de turma com token
        $turmaData = [
            'curso_id' => 8,
            'centro_id' => 4,
            'formador_id' => null,
            'periodo' => 'manhã',
            'status' => 'planeada',
            'hora_inicio' => '08:00',
            'hora_fim' => '10:00',
            'duracao_semanas' => 8,
            'data_arranque' => '2026-04-15',
            'vagas_totais' => 25,
            'publicado' => false,
            'dia_semana' => ['Segunda', 'Quarta', 'Sexta']
        ];

        $turmaResponse = $http->post('http://localhost:8000/api/turmas', [
            'json' => $turmaData,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $data['token']
            ]
        ]);

        echo "Turma criada com sucesso!\n";
        echo "Resposta: " . $turmaResponse->getBody()->getContents() . "\n";
    }

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}