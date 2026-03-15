# MC-COMERCIAL - Centro de Formação Profissional

Site público e painel de administração para gerenciamento de centros de formação, cursos, turmas, formadores e loja online em Angola.

## 🎯 Visão Geral

Plataforma completa de formação profissional com:
- **Site Público** - Blade + Tailwind CSS
- **Admin Panel** - Painel administrativo Laravel
- **Backend API** - REST API para futuras integrações
- **Loja Online** - Produtos e serviços

---

## 🔧 Requisitos do Sistema

- **PHP** >= 8.2
- **Composer** (gerenciador de dependências PHP)
- **MySQL** >= 5.7 ou **MariaDB** >= 10.3
- **Node.js** >= 16.x
- **NPM** >= 8.x
- **Git** (para versionamento)

---

## ⚙️ Instalação

### 1️⃣ Clone o repositório

```bash
git clone https://github.com/seu-usuario/Pendentes.git
cd Pendentes-main
```

### 2️⃣ Instale as dependências PHP

```bash
composer install
```

### 3️⃣ Instale as dependências Node.js

```bash
npm install
```

### 4️⃣ Configure o ambiente

```bash
cp .env.example .env
```

Edite o `.env` com seus dados:

```env
APP_NAME="MC-COMERCIAL"
APP_ENV=local
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=c_formacao_bd
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

### 5️⃣ Gere a chave da aplicação

```bash
php artisan key:generate
```

### 6️⃣ Execute as migrações

```bash
php artisan migrate:fresh --seed
```

### 7️⃣ Gere a documentação Swagger (opcional)

```bash
php artisan l5-swagger:generate
```

---

## 🚀 Executando o Projeto

### Terminal 1: Laravel Server

```bash
php artisan serve
```

Acesse: **http://localhost:8000**

### Terminal 2: Vite Dev Server

```bash
npm run dev
```

Compila Tailwind CSS e assets em tempo real.

---

## 📱 Estrutura do Site Público

### Páginas Blade (`resources/views/pages/`)

| Página | Rota | Descrição |
|--------|------|-----------|
| **home.blade.php** | `/` | Hero + Stats + Centros + Turmas |
| **centros.blade.php** | `/site/centros` | Lista de centros + mapa |
| **cursos.blade.php** | `/site/cursos` | Catálogo com filtros (busca, modalidade, área, centro) |
| **sobre.blade.php** | `/site/sobre` | História + Missão/Visão + Valores + Equipa |
| **contactos.blade.php** | `/site/contactos` | Formulário de contacto |
| **loja.blade.php** | `/site/loja` | Produtos e serviços |

### Componentes Reutilizáveis (`resources/views/partials/`)

| Componente | Descrição |
|------------|-----------|
| **navbar.blade.php** | Menu de navegação principal |
| **footer.blade.php** | Rodapé com links e contactos |
| **topbar.blade.php** | Barra superior com contactos rápidos |
| **whatsapp.blade.php** | Botão WhatsApp flutuante |
| **pre-inscricao-modal.blade.php** | Modal de pré-inscrição |

---

## 🎨 Design & Styling

- **Framework CSS**: Tailwind CSS v3
- **Icons**: Lucide Icons
- **Font**: Plus Jakarta Sans
- **Tema**: Customizado em `resources/css/app.css`

### Cores Principais

```css
--primary: hsl(224, 58%, 33%);      /* Azul escuro */
--accent: hsl(217, 91%, 60%);       /* Azul claro */
--background: hsl(210, 20%, 98%);   /* Cinzento muito claro */
--foreground: hsl(215, 25%, 15%);   /* Cinzento escuro */
```

---

## 📊 Modelos de Dados

### Centro
```php
- id
- nome
- localizacao
- contactos (JSON array)
- email
```

### Curso
```php
- id
- nome
- descricao
- programa
- area
- modalidade (presencial, online, hibrida)
- imagem_url
- ativo (boolean)
```

### Turma
```php
- id
- curso_id
- centro_id
- formador_id
- duracao_semanas
- dia_semana (JSON array)
- periodo
- hora_inicio
- hora_fim
- data_arranque
- status
- vagas_totais
- vagas_preenchidas
- publicado (boolean)
```

### Formador
```php
- id
- nome
- email
- contactos (JSON array)
- especialidade
- bio
- foto_url
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

Credenciais padrão:
- **Email**: admin@site.com
- **Senha**: senha123

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
