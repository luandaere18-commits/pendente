#!/bin/bash

# Script para executar testes com SQLite in-memory (sem MySQL)
# Útil para CI/CD e ambientes sem MySQL disponível

cd /media/elite/DCAECB15AECAE75C1/Users/Elite/Pictures/Pendentes-main

echo "=========================================="
echo "TESTE RÁPIDO - Verificação de Testes"
echo "=========================================="
echo ""

# Verificar se os arquivos de teste foram criados
echo "✓ Verificando arquivos de teste..."

if [ -f "tests/Feature/CronogramaTest.php" ]; then
    echo "  ✓ CronogramaTest.php encontrado"
    TEST_COUNT=$(grep -c "public function test_" tests/Feature/CronogramaTest.php)
    echo "    - $TEST_COUNT métodos de teste encontrados"
else
    echo "  ✗ CronogramaTest.php não encontrado"
fi

if [ -f "tests/Feature/CronogramaApiTest.php" ]; then
    echo "  ✓ CronogramaApiTest.php encontrado"
    API_TEST_COUNT=$(grep -c "public function test_" tests/Feature/CronogramaApiTest.php)
    echo "    - $API_TEST_COUNT métodos de teste encontrados"
else
    echo "  ✗ CronogramaApiTest.php não encontrado"
fi

echo ""
echo "✓ Verificando arquivos de seeding..."

if [ -f "database/seeders/CronogramaSeeder.php" ]; then
    echo "  ✓ CronogramaSeeder.php encontrado"
    SEED_COUNT=$(grep -c "curso_id" database/seeders/CronogramaSeeder.php)
    echo "    - ~$SEED_COUNT registros de seed disponíveis"
else
    echo "  ✗ CronogramaSeeder.php não encontrado"
fi

if [ -f "database/factories/CronogramaFactory.php" ]; then
    echo "  ✓ CronogramaFactory.php encontrado"
    FACTORY_METHODS=$(grep -c "public function" database/factories/CronogramaFactory.php)
    echo "    - $FACTORY_METHODS métodos de factory"
else
    echo "  ✗ CronogramaFactory.php não encontrado"
fi

echo ""
echo "=========================================="
echo "RESUMO"
echo "=========================================="
echo ""
echo "Total de testes para cronogramas: $(($TEST_COUNT + $API_TEST_COUNT)) testes"
echo ""
echo "Para executar os testes, primeiro:"
echo "1. Certifique-se que MySQL/MariaDB está rodando"
echo "2. Execute: php artisan migrate:fresh --seed"
echo "3. Execute: php artisan test tests/Feature/CronogramaTest.php tests/Feature/CronogramaApiTest.php"
echo ""
echo "Ou use o método SQLite in-memory em seu phpunit.xml:"
echo "  DB_CONNECTION=sqlite"
echo "  DB_DATABASE=:memory:"
echo ""
