# 🔧 Diagnóstico e Soluções - Pré-Inscrições

## ✅ Correções Implementadas

1. **Removida relação incorreta em Curso**
   - ❌ Antes: `preInscricoes()` tentando usar `curso_id` (não existe)
   - ✅ Depois: Removida relação incorreta

2. **Corrigido CursoController::show()**
   - ❌ Antes: Tentava carregar `preInscricoes` diretamente
   - ✅ Depois: Carrega apenas `['centros', 'turmas']`

3. **Corrigido formulário de pré-inscrição**
   - ❌ Antes: Enviava `curso_id` e `centro_id` (colunas não existem)
   - ✅ Depois: Envia apenas `turma_id`, `nome_completo`, `contactos` (array), `email`, `status`

## 🔍 Problema: Turmas Não Carregam

### Causa
A função `carregarTurmas()` no formulário procura filtrando por `curso_id`, mas o campo pode estar vazio.

### Solução
Verificar se a API de `/api/turmas` está retornando dados com `curso_id` completo.

### Como testar
```javascript
// No console do navegador:
fetch('/api/turmas')
  .then(r => r.json())
  .then(data => {
    console.log('Total turmas:', data.length);
    console.log('Primeira turma:', data[0]);
    console.log('Curso ID campo:', data[0]?.curso_id);
  });
```

## 📋 Estrutura Esperada de Dados

### Pré-Inscrição (POST /api/pre-inscricoes)
```json
{
  "turma_id": 1,
  "nome_completo": "João Silva",
  "contactos": ["+244 929643510", "joao@email.com"],
  "email": "joao@email.com",
  "status": "pendente"
}
```

### Turma (da API GET /api/turmas)
```json
{
  "id": 1,
  "curso_id": 7,
  "periodo": "manhã",
  "hora_inicio": "08:00",
  "hora_fim": "12:00",
  "data_arranque": "2024-03-15",
  "vagas_totais": 30,
  "vagas_preenchidas": 5,
  "publicado": true
}
```

## 🐛 Debugging

Se turmas ainda não carregarem:

1. Abrir DevTools (F12)
2. Ir para Console
3. Executar:
```javascript
// Test 1: Verificar API
fetch('/api/turmas').then(r => r.json()).then(console.log);

// Test 2: Se carregou em JavaScript
console.log('Turmas carregadas:', window.turmas || 'Não definido');
```

## ✨ Novos Bugs Encontrados?

Se houver novos erros, verificar:
1. Status HTTP da resposta
2. Mensagem de erro no console
3. Se campos obrigatórios estão preenchidos

---

Status: ✅ Pronto para Testar
