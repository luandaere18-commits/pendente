<?php
require 'bootstrap/app.php';
$app = app();

use App\Models\Formador;

echo "=== TESTE FORMADORES ===\n\n";

$f = Formador::with(['centros', 'turmas.curso'])->first();

if (!$f) {
    echo "❌ Nenhum formador encontrado\n";
    exit(1);
}

echo "✓ Formador: {$f->nome} (ID: {$f->id})\n\n";

echo "--- CONTACTOS ---\n";
echo "Raw (banco): " . ($f->getAttributes()['contactos'] ?? 'NULL') . "\n";
echo "Via accessor: " . json_encode($f->contactos) . "\n";
echo "Count: {$f->contactos_count}\n";
echo "String: {$f->contactos_string}\n\n";

echo "--- CURSOS ---\n";
echo "Turmas count: {$f->turmas->count()}\n";
foreach ($f->turmas as $turma) {
    echo "  - Turma {$turma->id}: curso_id={$turma->curso_id}\n";
}
echo "Cursos count: {$f->cursos_count}\n\n";

echo "--- CENTROS ---\n";
echo "Centros count: {$f->centros->count()}\n";
foreach ($f->centros as $centro) {
    echo "  - {$centro->nome}\n";
}

echo "\n✓ Teste concluído\n";
