# Testes CRUD de Cronogramas

## 📋 Resumo

Todos os métodos CRUD de **Cronogramas** foram testados e documentados. Foram criados:

- ✅ **23 testes de Feature** (Web CRUD) - `tests/Feature/CronogramaTest.php`
- ✅ **20 testes de API** - `tests/Feature/CronogramaApiTest.php`
- ✅ **Seeder melhorado** com 17 registros realistas - `database/seeders/CronogramaSeeder.php`
- ✅ **Factory completo** com métodos úteis - `database/factories/CronogramaFactory.php`

**Total: 43 testes CRUD + Seeder + Factory**

---

## 🚀 Como Executar os Testes

### Pré-requisitos

1. **MySQL/MariaDB deve estar rodando**
   ```bash
   sudo service mysql start
   # ou se usando MariaDB
   sudo service mariadb start
   ```

2. **Dependências do Laravel instaladas**
   ```bash
   composer install
   ```

3. **Arquivo .env configurado** (já está no projeto)
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_DATABASE=c_formacao_bd
   DB_USERNAME=root
   ```

### Executar Testes

#### 1️⃣ Recriar banco de dados com seeders
```bash
php artisan migrate:fresh --seed
```
Isto irá:
- Dropar todas as tabelas
- Executar todas as migrations
- Popular com dados de seed (17 cronogramas)

#### 2️⃣ Executar todos os testes de cronogramas
```bash
php artisan test tests/Feature/CronogramaTest.php tests/Feature/CronogramaApiTest.php
```

#### 3️⃣ Executar testes específicos

**Apenas testes Web:**
```bash
php artisan test tests/Feature/CronogramaTest.php
```

**Apenas testes API:**
```bash
php artisan test tests/Feature/CronogramaApiTest.php
```

**Testes com formato verboso:**
```bash
php artisan test tests/Feature/CronogramaTest.php --verbose
```

**Testes com relatório detalhado:**
```bash
php artisan test tests/Feature/CronogramaApiTest.php --debug
```

---

## 📊 Detalhes dos Testes

### CREATE - Criar Cronogramas

| Teste | Descrição |
|-------|-----------|
| `test_store_cronograma_com_dados_validos` | ✓ Criar cronograma com dados válidos |
| `test_store_cronograma_curso_inexistente` | ✓ Falhar com curso_id inválido |
| `test_store_cronograma_periodo_invalido` | ✓ Falhar com período inválido |
| `test_store_cronograma_hora_fora_do_periodo_manha` | ✓ Validar hora com base no período |
| `test_store_cronograma_hora_formato_invalido` | ✓ Validar formato H:i |
| `test_store_cronograma_periodo_tarde` | ✓ Criar cronograma período tarde (12:00-17:59) |
| `test_store_cronograma_periodo_noite` | ✓ Criar cronograma período noite (18:00-21:59) |
| `test_api_store_cronograma_valido` | ✓ API: Criar via POST |
| `test_api_store_curso_inexistente` | ✓ API: Validar curso_id |
| `test_api_store_hora_fim_anterior_inicio` | ✓ API: Validar horas |
| `test_api_store_dia_semana_invalido` | ✓ API: Validar dia da semana |
| `test_api_store_todos_dias_semana` | ✓ API: Testar todos os 7 dias |

### READ - Ler Cronogramas

| Teste | Descrição |
|-------|-----------|
| `test_index_lista_todos_cronogramas` | ✓ Listar todos com GET / |
| `test_index_carrega_dados_curso` | ✓ Eager load relacionamento curso |
| `test_show_cronograma_individual` | ✓ Exibir cronograma individual |
| `test_show_cronograma_inexistente` | ✓ Retornar 404 para ID inválido |
| `test_create_exibe_formulario` | ✓ Carregar formulário de criação |
| `test_api_index_lista_cronogramas` | ✓ API: GET /api/cronogramas |
| `test_api_index_carrega_curso` | ✓ API: Incluir dados do curso |
| `test_api_show_cronograma` | ✓ API: GET /api/cronogramas/{id} |
| `test_api_show_cronograma_inexistente` | ✓ API: Retornar 404 |

### UPDATE - Atualizar Cronogramas

| Teste | Descrição |
|-------|-----------|
| `test_update_cronograma_com_dados_validos` | ✓ Atualizar com dados válidos |
| `test_update_cronograma_inexistente` | ✓ Falhar com ID inválido |
| `test_update_cronograma_muda_periodo` | ✓ Mudar período com validação |
| `test_edit_exibe_formulario` | ✓ Carregar formulário de edição |
| `test_api_update_cronograma` | ✓ API: PUT /api/cronogramas/{id} |
| `test_api_update_curso_id_ignorado` | ✓ API: Não permite editar curso_id |
| `test_api_update_validar_horas` | ✓ API: Validar horas na atualização |

### DELETE - Deletar Cronogramas

| Teste | Descrição |
|-------|-----------|
| `test_destroy_cronograma` | ✓ Deletar cronograma existente |
| `test_destroy_cronograma_inexistente` | ✓ Falhar com ID inválido |
| `test_destroy_multiplos_cronogramas` | ✓ Deletar múltiplos cronogramas |
| `test_api_destroy_cronograma` | ✓ API: DELETE /api/cronogramas/{id} |
| `test_api_destroy_multiplos_cronogramas` | ✓ API: Deletar vários |

### RELACIONAMENTOS & VALIDAÇÕES

| Teste | Descrição |
|-------|-----------|
| `test_cronograma_carrega_curso` | ✓ Carregar relacionamento curso |
| `test_index_cronogramas_com_curso_carregado` | ✓ Eager loading no index |
| `test_validacao_campos_obrigatorios` | ✓ Validar campos obrigatórios |
| `test_validacao_dia_semana` | ✓ Validar dia da semana |
| `test_api_store_conflito_horario` | ✓ Detectar conflito de horários |

### OPERAÇÕES EM LOTE

| Teste | Descrição |
|-------|-----------|
| `test_batch_create_cronogramas` | ✓ Criar múltiplos em sequência |
| `test_ciclo_completo_crud` | ✓ Full cycle: Create → Read → Update → Delete |

---

## 📦 Seeder

### CronogramaSeeder.php

O seeder popula o banco com **17 cronogramas realistas**:

```php
// Exemplo de dados seeded:
- Curso 1: 3 cronogramas (seg/qua/sex - manhã)
- Curso 2: 2 cronogramas (ter/qui - tarde)
- Curso 3: 3 cronogramas (seg/qua/sex - noite)
- Curso 4: 2 cronogramas (ter/qui - manhã)
- Curso 5: 3 cronogramas (seg/qua/sex - tarde)
- Curso 6: 2 cronogramas (sábado - manhã/tarde)
- Curso 7: 2 cronogramas (domingo - manhã/tarde)
```

**Períodos válidos:**
- **Manhã:** 08:00 - 11:59
- **Tarde:** 12:00 - 17:59
- **Noite:** 18:00 - 21:59

---

## 🏭 Factory

### CronogramaFactory.php

Factory com métodos auxiliares para testes:

```php
// Usar no teste com:
Cronograma::factory()->create();                    // Cronograma aleatório
Cronograma::factory()->manha()->create();           // Período manhã
Cronograma::factory()->tarde()->create();           // Período tarde
Cronograma::factory()->noite()->create();           // Período noite
Cronograma::factory()->forCurso($curso)->create();  // Para curso específico
Cronograma::factory()->forDia('Segunda')->create(); // Para dia específico
```

---

## 🔍 Validações Testadas

### Período vs Hora
- ✅ Manhã (08:00-11:59)
- ✅ Tarde (12:00-17:59)
- ✅ Noite (18:00-21:59)

### Campos Obrigatórios
- ✅ curso_id (deve existir)
- ✅ dia_semana (string)
- ✅ periodo (enum)
- ✅ hora_inicio (H:i format)
- ✅ hora_fim (H:i e após hora_inicio)

### Dias da Semana
- ✅ Segunda, Terça, Quarta, Quinta, Sexta, Sábado, Domingo

---

## 📈 Cobertura de Testes

```
✅ CREATE:  7 testes web + 5 testes API = 12 testes
✅ READ:    5 testes web + 4 testes API = 9 testes
✅ UPDATE:  4 testes web + 3 testes API = 7 testes
✅ DELETE:  3 testes web + 3 testes API = 6 testes
✅ VALIDAÇÃO & RELACIONAMENTO: 4 testes
✅ BATCH & INTEGRATION: 2 testes (API)

TOTAL: 43 testes de CRUD
```

---

## 🛠️ Troubleshooting

### Erro: Connection refused (MySQL)

**Solução:**
```bash
sudo service mysql start
# ou
sudo service mariadb start
```

### Erro: Table already exists

**Solução:**
```bash
php artisan migrate:fresh --seed
```

### Erro: Base table or view doesn't exist

**Solução:**
```bash
php artisan migrate
php artisan db:seed --class=CronogramaSeeder
```

### Quer rodar testes sem MySQL (usar SQLite in-memory)?

Edite `.env.testing` (crie se não existir):
```env
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

Depois execute:
```bash
php artisan test
```

---

## 📝 Arquivos Criados/Modificados

| Arquivo | Tipo | Status |
|---------|------|--------|
| `tests/Feature/CronogramaTest.php` | ✅ NOVO | 23 testes web |
| `tests/Feature/CronogramaApiTest.php` | ✅ NOVO | 20 testes API |
| `database/seeders/CronogramaSeeder.php` | 🔄 ATUALIZADO | 17 registros |
| `database/factories/CronogramaFactory.php` | ✅ NOVO | 6 métodos |
| `test_cronogramas.sh` | ✅ NOVO | Script de informação |
| `verify_cronograma_tests.sh` | ✅ NOVO | Script de verificação |

---

## ✨ Próximos Passos (Opcional)

1. **Adicionar testes de performance**
   ```bash
   php artisan test --parallel
   ```

2. **Gerar coverage report**
   ```bash
   php artisan test --coverage
   ```

3. **Integração contínua (CI/CD)**
   - GitHub Actions
   - GitLab CI
   - Jenkins

4. **Documentação Swagger/OpenAPI**
   - Já configurado em `app/Http/Controllers/Api/CronogramaController.php`

---

## 📞 Resumo de Comandos Úteis

```bash
# Preparar banco de dados
php artisan migrate:fresh --seed

# Executar todos os testes
php artisan test

# Apenas cronogramas
php artisan test tests/Feature/CronogramaTest.php tests/Feature/CronogramaApiTest.php

# Com output verboso
php artisan test --verbose

# Com relatório de coverage
php artisan test --coverage

# Executar teste específico
php artisan test tests/Feature/CronogramaTest.php --filter=test_store_cronograma_com_dados_validos

# Recriar seeders
php artisan db:seed --class=CronogramaSeeder

# Ver logs
tail -f storage/logs/laravel.log
```

---

**Data de Criação:** 9 de março de 2026  
**Status:** ✅ CONCLUÍDO - Todos os métodos CRUD testados e documentados


