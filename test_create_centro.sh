#!/bin/bash

BASE_URL="http://127.0.0.1:8000"
COOKIE_JAR="/tmp/cookies.txt"

# Limpar cookies anteriores
rm -f "$COOKIE_JAR"

echo "=== TESTE DE CRIAÇÃO DE CENTRO ==="
echo ""

# Passo 1: Obter CSRF token da página de login
echo "[1] Obtendo CSRF token..."
LOGIN_PAGE=$(curl -s -c "$COOKIE_JAR" "$BASE_URL/login")
CSRF_TOKEN=$(echo "$LOGIN_PAGE" | grep -oP '(?<=name="csrf_token" content=")[^"]+' || echo "$LOGIN_PAGE" | grep -oP '(?<=name="csrf-token" content=")[^"]+')

if [ -z "$CSRF_TOKEN" ]; then
    # Tentar extrair de uma meta tag
    CSRF_TOKEN=$(echo "$LOGIN_PAGE" | grep -oP 'csrf-token[^>]*content=["\x27]\K[^"\x27]+' | head -1)
fi

echo "CSRF Token: $CSRF_TOKEN"
echo ""

# Passo 2: Fazer login
echo "[2] Fazendo login..."
LOGIN_RESPONSE=$(curl -s -X POST -b "$COOKIE_JAR" -c "$COOKIE_JAR" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "email=admin@site.com&password=12345678&_token=$CSRF_TOKEN" \
  "$BASE_URL/login")

echo "Login response: $(echo "$LOGIN_RESPONSE" | head -c 200)"
echo ""

# Passo 3: Obter a página de criar centro
echo "[3] Acessando página de criar centro..."
CREATE_PAGE=$(curl -s -b "$COOKIE_JAR" "$BASE_URL/centros/create")
CSRF_TOKEN_CREATE=$(echo "$CREATE_PAGE" | grep -oP 'csrf-token[^>]*content=["\x27]\K[^"\x27]+' | head -1)

echo "CSRF Token para create: $CSRF_TOKEN_CREATE"
echo ""

# Passo 4: Tentar criar um centro
echo "[4] Criando centro..."
CREATE_RESPONSE=$(curl -s -X POST -b "$COOKIE_JAR" -c "$COOKIE_JAR" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "nome=Test Centro $(date +%s)&localizacao=Test Location&contactos%5B0%5D=923111111&_token=$CSRF_TOKEN_CREATE" \
  "$BASE_URL/centros")

echo "Create response (first 300 chars): $(echo "$CREATE_RESPONSE" | head -c 300)"
echo ""

if echo "$CREATE_RESPONSE" | grep -q "Centro"; then
    echo "✅ SUCESSO: Centro criado!"
else
    echo "❌ ERRO: Falha ao criar centro"
fi

# Limpar
rm -f "$COOKIE_JAR"
