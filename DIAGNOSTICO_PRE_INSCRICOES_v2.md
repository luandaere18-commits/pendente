# Diagnóstico e Correção: Pré-Inscrições 📋

## Status: ✅ CORRIGIDO

Data: 2025-01-15
Versão: 2.0

---

## 🔴 Problemas Identificados e Soluções

### Problema 1: SQL Error - "Column not found: pre_inscricoes.curso_id"
**Status:** ✅ CORRIGIDO

**Causa Root:**
- Model `Curso` tinha método `preInscricoes()` que tentava fazer JOIN em coluna inexistente `pre_inscricoes.curso_id`
- Tabela `pre_inscricoes` usa `turma_id` como FK, não `curso_id`

**Solução Aplicada:**
- ✅ Removido método `preInscricoes()` de `app/Models/Curso.php`
- ✅ Atualizado `app/Http/Controllers/CursoController.php` para não carregar relacionamento inválido

---

### Problema 2: Turmas Não Carregam no Select
**Status:** ✅ CORRIGIDO

**Causa Root:**
- Função `carregarTurmas()` tentava filtrar em array `turmas` que poderia estar vazio
- Carregamento AJAX paralelo do `/api/turmas` pode não ter terminado
- Sem tratamento de erro ou fallback

**Solução Aplicada:**
- ✅ Reformulada `carregarTurmas()` com verificação de cache
- ✅ Fallback automático para carregar do API se estiver vazio
- ✅ Separada lógica em `exibirTurmasDisponíveis()` para melhor controle

**Code Changes:**
```javascript
// IMPLEMENTADO:
function carregarTurmas() {
    const cursoId = $('#curso_id').val();
    
    if (!cursoId || turmas.length === 0) {
        // Recarregar turmas se vazio
        $.get('/api/turmas?publicado=true', function(data) {
            turmas = Array.isArray(data) ? data : (data.data || []);
            exibirTurmasDisponíveis(cursoId);
        });
    } else {
        exibirTurmasDisponíveis(cursoId);
    }
}
```

---

### Problema 3: Formulário Enviava Campos Incorretos
**Status:** ✅ CORRIGIDO

**Causa Root:**
- Enviava `curso_id`, `centro_id` que não existem na tabela
- Contactos como JSON string em vez de array
- Sem campo `status`

**Solução Aplicada:**
- ✅ Alterado para enviar apenas: `{turma_id, nome_completo, email, contactos[], status}`

---

### Problema 4: Status Não Visível
**Status:** ⚠️ POR DESIGN (Correto)

- Status é `'pendente'` por padrão
- User público não escolhe (segurança)
- Admin altera no painel de controle

---

## 📊 Schema da Tabela pre_inscricoes

```sql
CREATE TABLE pre_inscricoes (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    turma_id BIGINT NOT NULL,        ← FK CORRETA
    nome_completo VARCHAR(100) NOT NULL,
    contactos JSON NOT NULL,
    email VARCHAR(100) NULLABLE,
    status ENUM('pendente', 'confirmado', 'cancelado') DEFAULT 'pendente',
    observacoes TEXT NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Validação:**
- ✅ `turma_id` existe (FK para turmas)
- ❌ `curso_id` NÃO existe
- ❌ `centro_id` NÃO existe

---

## 🔍 API Endpoints

### GET /api/turmas
Retorna turmas com `curso_id`, `formador_id`, relacionamentos inclusos

### POST /api/pre-inscricoes
Aceita:
```json
{
  "turma_id": 1,
  "nome_completo": "João Silva",
  "contactos": ["+244 929643510", "joao@email.com"],
  "email": "joao@email.com",
  "status": "pendente"
}
```

---

## ✅ Checklist de Testes

- [ ] **Teste 1:** Aceder a http://127.0.0.1:8000/pre-inscricoes (sem SQL error)
- [ ] **Teste 2:** Selecionar curso e turmas carregam no dropdown
- [ ] **Teste 3:** Preencher e submeter formulário
- [ ] **Teste 4:** Ver dados no admin com status 'pendente'

---

## 🐛 Debug (se necessário)

```javascript
// Console: Ver turmas disponíveis
fetch('/api/turmas').then(r => r.json()).then(data => {
  console.log('Total:', data.length);
  console.log('Primeira turma:', data[0]);
  console.log('Curso ID field:', data[0]?.curso_id);
});
```

---

**Todas as correções estão implementadas e pronto para teste.** ✅
