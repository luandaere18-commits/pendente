<?php
// Script para testar a página autenticado
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'http://127.0.0.1:8000/login',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_COOKIEJAR => 'cookies.txt',
    CURLOPT_COOKIEFILE => 'cookies.txt',
]);

$response = curl_exec($ch);
preg_match('/<input[^>]*name="_token"[^>]*value="([^"]+)"/', $response, $matches);
$token = $matches[1] ?? '';

echo "=== TESTE COMPLETO DE FORMADORES ===\n\n";

// Fazer login
curl_setopt_array($ch, [
    CURLOPT_URL => 'http://127.0.0.1:8000/login',
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        'email' => 'admin@site.com',
        'password' => 'senha123',
        '_token' => $token,
    ]),
    CURLOPT_FOLLOWLOCATION => true,
]);

$login_response = curl_exec($ch);

// Agora acessar página de formadores
curl_setopt_array($ch, [
    CURLOPT_URL => 'http://127.0.0.1:8000/formadores',
    CURLOPT_POST => false,
]);

$formadores_response = curl_exec($ch);
curl_close($ch);

// Extrair dados de cada formador
$nomes = ['Ana Silva', 'Bruno Costa', 'Daniel Rocha', 'Eduarda Lima', 'Fernando Pinto'];

foreach ($nomes as $nome) {
    if (preg_match('/(' . preg_quote($nome) . ').*?<td.*?class="text-center".*?>(.*?)<\/td>.*?<td.*?class="text-center".*?>(.*?)<\/td>/s', $formadores_response, $m)) {
        echo "✓ $nome\n";
        // Extrair badge content
        if (preg_match('/badge[^>]*>(\d+)<\/.*?badge/s', $m[2], $b)) {
            echo "   Cursos: " . $b[1] . "\n";
        }
        if (preg_match('/badge[^>]*>(\d+)<\/.*?badge/s', $m[3], $b)) {
            echo "   Contactos: " . $b[1] . "\n";
        }
    } else {
        echo "✗ $nome não encontrado\n";
    }
}

echo "\n=== RESULTADO GERAL ===\n";
preg_match_all('/<strong>.*?<\/strong>/s', $formadores_response, $m);
echo "Formadores encontrados: " . count($m[0]) . "\n";
echo "Badges de cursos (info): " . substr_count($formadores_response, 'badge bg-info') . "\n";
echo "Badges de contactos (success): " . substr_count($formadores_response, 'badge bg-success') . "\n";
echo "Badges secundários: " . substr_count($formadores_response, 'badge bg-secondary') . "\n";
?>

