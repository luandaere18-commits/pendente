# MC-COMERCIAL - Plataforma de Formação Profissional 🎓

**Plataforma completa de gestão de centros de formação profissional em Angola**

[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat-square&logo=php)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v3-38B2AC?style=flat-square&logo=tailwindcss)](https://tailwindcss.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?style=flat-square&logo=mysql)](https://mysql.com)

---

## 📋 Índice

- [Visão Geral](#-visão-geral)
- [Pré-requisitos](#-pré-requisitos)
- [Instalação Rápida](#-instalação-rápida)
- [Como Executar](#-como-executar)
- [Credenciais de Acesso](#-credenciais-de-acesso)
- [Estrutura do Projeto](#-estrutura-do-projeto)
- [API REST](#-api-rest)
- [Troubleshooting](#-troubleshooting)

---

## 🎯 Visão Geral

Plataforma completa para gerenciamento de **centros de formação profissional** com:

| Módulo | Descrição |
|--------|-----------|
| 🌐 **Site Público** | Homepage, catálogo de turmas, pré-inscrições, loja online |
| 🎛️ **Admin Panel** | Dashboard para gestão de centros, cursos, turmas, formadores, itens e pré-inscrições |
| 🔌 **REST API** | Endpoints para integração com sistemas externos |
| 🛒 **Loja Online** | Produtos e serviços com separação por categorias e grupos |
| 📱 **Responsive** | Design mobile-first com Tailwind CSS |

---

## 🔧 Pré-requisitos

Certifique-se de ter instalado:

| Software | Versão | Download |
|----------|--------|----------|
| **PHP** | >= 8.2 | [php.net](https://php.net/downloads) |
| **Composer** | Última | [getcomposer.org](https://getcomposer.org) |
| **MySQL** | >= 5.7 | [mysql.com](https://mysql.com/downloads) ou [MariaDB](https://mariadb.org) |
| **Node.js** | >= 16.x | [nodejs.org](https://nodejs.org) |
| **Git** | Última | [git-scm.com](https://git-scm.com) |
| **FileZilla** (opcional) | - | Para upload FTP em produção |

**Verificar instalação:**
```bash
php --version
composer --version
node --version
npm --version
git --version
mysql --version
```

---

## ⚡ Instalação Rápida

### 1️⃣ Clonar o Repositório

```bash
git clone https://github.com/seu-usuario/Pendentes.git
cd Pendentes-main
```

### 2️⃣ Criar Base de Dados

```bash
# Abrir MySQL/MariaDB
mysql -u root -p

# Criar banco de dados
CREATE DATABASE c_formacao_bd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 3️⃣ Configurar Ambiente

```bash
cp .env.example .env
```

**Editar `.env` com seus dados:**

```env
APP_NAME="MC-COMERCIAL"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=c_formacao_bd
DB_USERNAME=root
DB_PASSWORD=sua_senha_aqui

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu_usuario
MAIL_PASSWORD=sua_senha
MAIL_FROM_ADDRESS="no-reply@mc-comercial.ao"
```

### 4️⃣ Instalar Dependências

```bash
# Dependências PHP
composer install

# Dependências Node.js
npm install
```

### 5️⃣ Gerar Chave da Aplicação

```bash
php artisan key:generate
```

### 6️⃣ Criar Tabelas e Dados

```bash
# Criar todas as tabelas e popular com dados de exemplo
php artisan migrate:fresh --seed

# Ou apenas migrações (sem dados de exemplo)
php artisan migrate
```

### 7️⃣ Gerar Documentação API (Swagger)

```bash
php artisan l5-swagger:generate
```

### 8️⃣ Compilar Assets

```bash
npm run build
```

✅ **Pronto! Instalação concluída.**

---

## 🚀 Como Executar

### **Opção 1: Em Desenvolvimento (Local)**

Abra **3 terminais diferentes** na pasta do projeto:

**Terminal 1 - Laravel Development Server:**
```bash
php artisan serve
```
✅ Acesse: **http://localhost:8000**

**Terminal 2 - Vite Assets Compiler (CSS/JS):**
```bash
npm run dev
```
✅ Compila Tailwind CSS e JavaScript em tempo real

**Terminal 3 - Optional: Verificar Logs (se necessário):**
```bash
tail -f storage/logs/laravel.log
```

**Estrutura de URLs em Desenvolvimento:**

| Página | URL |
|--------|-----|
| 🏠 Homepage | http://localhost:8000 |
| 📚 Catálogo Turmas | http://localhost:8000/site/cursos |
| 🏢 Centros | http://localhost:8000/site/centros |
| 🛒 Loja | http://localhost:8000/site/loja |
| 💼 Admin Panel | http://localhost:8000/dashboard |
| 📖 API Docs (Swagger) | http://localhost:8000/api/documentation |

### **Opção 2: Produção**

```bash
# Build otimizado
npm run build

# Iniciar servidor em produção
php artisan serve --env=production
```

---

## 🔐 Credenciais de Acesso

### **Admin Padrão (após `php artisan migrate:fresh --seed`)**

```
Email: admin@mc-comercial.ao
Senha: password
```

**Acessar em:** http://localhost:8000/login

### **Criar Novo Usuário Admin (via CLI)**

```bash
php artisan tinker
```

```php
User::create([
    'name' => 'Seu Nome',
    'email' => 'seu@email.ao',
    'password' => bcrypt('senha123'),
]);
exit
```

### **Resetar Password Admin**

```bash
php artisan tinker
User::find(1)->update(['password' => bcrypt('nova_senha')]);
exit
```

---

## 📁 Estrutura do Projeto

```
Pendentes-main/
├── app/
│   ├── Http/Controllers/
│   │   ├── Api/                    # Controladores REST API
│   │   │   ├── PreInscricaoController.php
│   │   │   ├── TurmaController.php
│   │   │   └── ...
│   │   └── Web/
│   │       ├── SiteController.php  # Site Público
│   │       ├── TurmaController.php # Admin
│   │       └── ...
│   └── Models/
│       ├── Categoria.php
│       ├── Centro.php
│       ├── Curso.php
│       ├── Formador.php
│       ├── Grupo.php
│       ├── Item.php
│       ├── PreInscricao.php
│       ├── Turma.php
│       └── User.php
├── resources/
│   ├── css/
│   │   └── app.css                # Tailwind customizado
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views/
│       ├── pages/                 # Site Público (7 páginas)
│       ├── partials/              # Componentes reutilizáveis
│       ├── auth/                  # Páginas de login
│       └── (admin CRUD views)     # Dashboard admin
├── routes/
│   ├── web.php                    # Routes web (site + admin)
│   └── api.php                    # Routes API REST
├── database/
│   ├── migrations/                # Schema database
│   ├── seeders/                   # Dados de exemplo
│   └── factories/                 # Factory para testes
├── config/
│   ├── app.php
│   ├── database.php
│   ├── filesystems.php
│   └── l5-swagger.php             # Swagger config
└── storage/
    ├── app/                       # Uploads de usuários
    ├── logs/                      # Logs da aplicação
    └── api-docs/                  # Documentação Swagger
```

---

## 🌐 Site Público - Páginas

| Página | Rota | Descrição |
|--------|------|-----------|
| **Home** | `/` | Hero, estatísticas, centros, turmas em destaque |
| **Centros** | `/site/centros` | Lista de centros com localização e contactos |
| **Cursos/Turmas** | `/site/cursos` | Catálogo com filtros (busca, status, período, centro) + pré-inscrição |
| **Loja** | `/site/loja` | Produtos e serviços por categorias, com snackbar |
| **Serviços** | `/site/servicos` | Detalhes dos serviços oferecidos |
| **Sobre** | `/site/sobre` | História, missão/visão, valores, equipa |
| **Contactos** | `/site/contactos` | Formulário de contacto e informações |

---

## 🎛️ Admin Panel - Módulos

| Módulo | URL | Funções |
|--------|-----|---------|
| **Dashboard** | `/dashboard` | Resumo geral da plataforma |
| **Centros** | `/centros` | CRUD completo (Criar, Ler, Editar, Deletar) |
| **Cursos** | `/cursos` | Gestão de cursos com associação a centros |
| **Turmas** | `/turmas` | Criar turmas, controlar vagas, status, formadores |
| **Formadores** | `/formadores` | Cadastro e gestão de formadores |
| **Grupos** | `/grupos` | Categorização hierárquica |
| **Categorias** | `/categorias` | Categorias de itens |
| **Itens** | `/itens` | Produtos e serviços da loja |
| **Pré-inscrições** | `/pre-inscricoes` | Gerir pré-inscrições de turmas |

---

## 🔌 API REST

Endpoints disponíveis em `/api`:

### **Pré-inscrições**
```
POST   /api/pre-inscricoes           # Criar pré-inscrição
GET    /api/pre-inscricoes           # Listar
GET    /api/pre-inscricoes/{id}      # Detalhe
PUT    /api/pre-inscricoes/{id}      # Atualizar
DELETE /api/pre-inscricoes/{id}      # Deletar
```

### **Turmas**
```
GET    /api/turmas                   # Listar turmas
GET    /api/turmas/{id}              # Detalhe turma
GET    /api/turmas/curso/{cursoId}   # Turmas de um curso
```

### **Centros**
```
GET    /api/centros                  # Listar centros
GET    /api/centros/{id}             # Detalhe centro
```

**Documentação Completa:** http://localhost:8000/api/documentation

---

## 💾 Modelos de Dados

### **User (Autenticação)**
```php
- id (UUID)
- name (string)
- email (string unique)
- password (hashed)
- timestamps
```

### **Grupo**
```php
- id
- nome (string) - ex: "Snackbar", "Produtos"
- display_name (string) - ex: "Snack Bar", "Produtos"
- ordem (integer)
- ativo (boolean)
```

### **Categoria**
```php
- id
- grupo_id (foreign key)
- nome (string)
- descricao (text nullable)
- ordem (integer)
- ativo (boolean)
```

### **Item (Produtos/Serviços da Loja)**
```php
- id
- categoria_id (foreign key)
- nome (string)
- descricao (text nullable)
- preco (decimal nullable) - em centavos
- imagem (string nullable)
- tipo (enum: 'produto', 'servico')
- destaque (boolean)
- ordem (integer)
- ativo (boolean)
```

### **Centro**
```php
- id
- nome (string)
- localizacao (text nullable)
- contactos (json array) - ex: ["+244 923456789"]
- email (string nullable)
- ativo (boolean)
```

### **Curso**
```php
- id
- nome (string)
- descricao (text nullable)
- programa (text nullable)
- area (string nullable) - ex: "Tecnologia"
- modalidade (enum) - 'presencial', 'online', 'hibrida'
- imagem_url (string nullable)
- ativo (boolean)
```

### **Turma**
```php
- id
- curso_id (foreign key)
- centro_id (foreign key)
- formador_id (foreign key nullable)
- duracao_semanas (integer nullable)
- dia_semana (json array) - ex: ["Segunda", "Terça"]
- periodo (enum) - 'manha', 'tarde', 'noite'
- hora_inicio (time nullable)
- hora_fim (time nullable)
- data_arranque (date nullable)
- status (enum) - 'planeada', 'inscricoes_abertas', 'em_andamento', 'concluida'
- vagas_totais (integer)
- vagas_preenchidas (integer)
- publicado (boolean)
```

### **Formador**
```php
- id
- nome (string)
- email (string nullable)
- contactos (json array)
- especialidade (string nullable)
- bio (text nullable)
- foto_url (string nullable)
- ativo (boolean)
```

### **PreInscricao**
```php
- id
- turma_id (foreign key)
- nome_completo (string)
- contactos (json array) - ex: ["+244 923456789", "+244 924567890"]
- email (string nullable)
- status (enum) - 'pendente', 'confirmado', 'cancelado' (default: 'pendente')
- observacoes (text nullable)
- timestamps
```

---

## 🎨 Customização
```

### Grupo (Loja)
```php
- id
- nome
- display_name
```

### Categoria
```php
- id
- grupo_id
- nome
- descricao
```

### Item (Produtos/Serviços)
```php
- id
- categoria_id
- nome
- descricao
- preco
- imagem_url
- destaque (boolean)
- ativo (boolean)
```

---

## 🔐 Autenticação

### Painel Administrativo

Acesse: **http://localhost:8000/login**

**Credenciais padrão (após `php artisan migrate:fresh --seed`):**
- **Email**: admin@mc-comercial.ao
- **Senha**: password

**⚠️ Altere a senha na primeira vez que entrar em produção!**

### Criar Novo Admin via Terminal

```bash
php artisan tinker

# Executar no Tinker:
User::create([
    'name' => 'Novo Admin',
    'email' => 'novo@mc-comercial.ao',
    'password' => bcrypt('senha_forte_aqui'),
]);
exit
```

### Resetar Password Admin

```bash
php artisan tinker
User::find(1)->update(['password' => bcrypt('nova_senha')]);
exit
```

---

## 🌐 Rotas Disponíveis

### Site Público (Sem autenticação)

```
GET  /                          Home
GET  /site/centros              Centros de Formação
GET  /site/centro/{id}          Detalhes do Centro
GET  /site/cursos               Catálogo de Cursos
GET  /site/sobre                Sobre Nós
GET  /site/contactos            Contacte-nos
GET  /site/loja                 Loja Online
```

### Painel Admin (Com autenticação)

```
GET    /dashboard               Dashboard
GET    /cursos                  Gerenciar Cursos
POST   /cursos                  Criar Curso
PUT    /cursos/{id}             Atualizar Curso
DELETE /cursos/{id}             Deletar Curso

GET    /centros                 Gerenciar Centros
POST   /centros                 Criar Centro
PUT    /centros/{id}            Atualizar Centro
DELETE /centros/{id}            Deletar Centro

GET    /formadores              Gerenciar Formadores
POST   /formadores              Criar Formador
PUT    /formadores/{id}         Atualizar Formador
DELETE /formadores/{id}         Deletar Formador

GET    /turmas                  Gerenciar Turmas
POST   /turmas                  Criar Turma
PUT    /turmas/{id}             Atualizar Turma
DELETE /turmas/{id}             Deletar Turma

GET    /pre-inscricoes          Ver Pré-inscrições
GET    /grupos                  Gerenciar Grupos Loja
```

---

## 📁 Estrutura do Projeto

```
Pendentes-main/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── SiteController.php        Lógica do site público
│   │   ├── Kernel.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── Centro.php
│   │   ├── Curso.php
│   │   ├── Formador.php
│   │   ├── Turma.php
│   │   ├── PreInscricao.php
│   │   ├── Grupo.php
│   │   ├── Categoria.php
│   │   └── Item.php
│   └── Providers/
│
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── public.blade.php           Layout principal
│   │   ├── pages/
│   │   │   ├── home.blade.php
│   │   │   ├── centros.blade.php
│   │   │   ├── cursos.blade.php
│   │   │   ├── sobre.blade.php
│   │   │   ├── contactos.blade.php
│   │   │   └── loja.blade.php
│   │   └── partials/
│   │       ├── navbar.blade.php
│   │       ├── footer.blade.php
│   │       ├── topbar.blade.php
│   │       ├── whatsapp.blade.php
│   │       └── pre-inscricao-modal.blade.php
│   ├── css/
│   │   └── app.css                       Tailwind + Custom CSS
│   └── js/
│       ├── app.js
│       └── bootstrap.js
│
├── routes/
│   ├── web.php                           Rotas do site
│   ├── api.php                           API REST (opcional)
│   └── console.php
│
├── database/
│   ├── migrations/                       Estrutura da BD
│   ├── seeders/                          Dados iniciais
│   └── factories/                        Factories para testes
│
├── config/
│   ├── app.php
│   ├── database.php
│   ├── cors.php
│   └── ...
│
├── public/
│   ├── index.php                         Entry point
│   ├── images/                           Imagens estáticas
│   └── storage/                          Uploads
│
├── tailwind.config.js                    Config Tailwind
├── vite.config.js                        Config Vite
├── package.json
├── composer.json
└── .env
```

---

## 🛠️ Comandos Úteis

### Laravel

```bash
# Criar nova migração
php artisan make:migration create_novo_modelo

# Criar novo modelo
php artisan make:model NomeModelo -m

# Criar novo controller
php artisan make:controller NomeController

# Resetar banco de dados com seeds
php artisan migrate:fresh --seed

# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### NPM

```bash
# Build para produção
npm run build

# Dev watch
npm run dev

# Audit de dependências
npm audit fix
```

---

## 🚀 Deploy

### Requisitos Servidor

- PHP 8.2+
- MySQL 5.7+
- Composer instalado
- Node.js 16+ (para build)
- Git instalado

### Passos

```bash
# 1. Clone o repositório
git clone https://github.com/seu-usuario/Pendentes.git
cd Pendentes-main

# 2. Instale dependências
composer install --optimize-autoloader --no-dev
npm ci

# 3. Configure ambiente
cp .env.example .env
php artisan key:generate

# 4. Configure .env para produção
# Atualize: DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD
# APP_ENV=production
# APP_DEBUG=false

# 5. Execute migrações
php artisan migrate --force

# 6. Build assets
npm run build

# 7. Clear cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Configure nginx/apache para apontar a /public
```

---

## 📞 Contactos

- **Email**: contato@mc-comercial.ao
- **Telefone**: +244 222 123 456
- **Localização**: Luanda, Angola

---

## 🤝 Contribuindo

1. Faça um Fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

---

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

## 👨‍💻 Autor

**MC-COMERCIAL Development Team**
- 📧 dev@mc-comercial.ao
- 🔗 [GitHub](https://github.com/seu-usuario)

---

## 🐛 Troubleshooting

### ❌ Erro: "SQLSTATE[HY000]: General error: 1030"

**Solução:** Aumentar max_allowed_packet no MySQL

```bash
mysql -u root -p
SET GLOBAL max_allowed_packet=268435456;
EXIT;
```

### ❌ Erro: "No application encryption key has been specified"

```bash
php artisan key:generate
```

### ❌ "Class not found" ou "Composer autoload failed"

```bash
composer dumpautoload
```

### ❌ Assets CSS/JS não carregam em desenvolvimento

```bash
# Recompilar assets
npm run dev

# Ou build final
npm run build
```

### ❌ Base de dados não existe

```bash
# Abrir MySQL e criar base de dados
mysql -u root -p
CREATE DATABASE c_formacao_bd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;

# Executar migrações
php artisan migrate:fresh --seed
```

### ❌ Erro: "The database does not contain an 'users' table"

```bash
php artisan migrate
php artisan db:seed
```

### ✨ Limpar cache e otimizar

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear
```

### 📁 Verificar Permissões (Linux/Mac)

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
touch storage/logs/laravel.log
```

### ❌ Erro: "Call to undefined function"

```bash
composer dump-autoload
php artisan optimize:clear
```

---

## 📚 Documentação Adicional

### Links Úteis
- [Laravel 11 Documentation](https://laravel.com/docs/11.x)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Lucide Icons](https://lucide.dev)
- [Alpine.js](https://alpinejs.dev/start-here)
- [MySQL 8.0](https://dev.mysql.com/doc/refman/8.0/en/)

### Variáveis de Ambiente Importantes

```env
# App
APP_NAME=MC-COMERCIAL
APP_ENV=local|production
APP_DEBUG=true|false
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=c_formacao_bd
DB_USERNAME=root
DB_PASSWORD=

# Mail (para notificações)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu_usuario
MAIL_PASSWORD=sua_senha

# Storage (para uploads)
FILESYSTEM_DISK=public
```

---

## ✅ Checklist de Deploy

- [ ] Clonar repositório
- [ ] Instalar Composer e NPM
- [ ] Copiar `.env.example` para `.env`
- [ ] Gerar chave com `php artisan key:generate`
- [ ] Configurar dados de BD no `.env`
- [ ] Criar base de dados MySQL
- [ ] Executar `php artisan migrate:fresh --seed`
- [ ] Compilar assets com `npm run build`
- [ ] Testar login em http://localhost:8000/login
- [ ] Testar site público em http://localhost:8000
- [ ] Testar API em http://localhost:8000/api/documentation
- [ ] Fazer commit e push para GitHub

---

## 📊 Roadmap Futuro

- [ ] Painel Analytics com gráficos
- [ ] Sistema de notificações por email
- [ ] Mobile App (React Native)
- [ ] Integração com SMS (Twilio)
- [ ] Certificados digitais
- [ ] Sistema de pagamentos
- [ ] Relatórios em PDF

---

## 📝 Últimas Alterações

**Versão 1.0 - Março 2026**
- ✅ Site público completo
- ✅ Admin panel funcional
- ✅ REST API implementada
- ✅ Modal pré-inscrição com contactos dinâmicos
- ✅ Loja online com snackbar
- ✅ Sistema de autenticação

**Nota:** Projeto em desenvolvimento ativo. Acompanhe as atualizações no GitHub.

---

## 🙏 Agradecimentos

Obrigado por usar MC-COMERCIAL! Se encontrar bugs ou tiver sugestões, por favor abra uma issue no GitHub.

**Desenvolvido com ❤️ em Angola**
