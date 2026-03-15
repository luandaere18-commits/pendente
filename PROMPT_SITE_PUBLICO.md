# 🚀 PROMPT PARA GERAÇÃO DO SITE PÚBLICO MC-COMERCIAL

## 📋 CONTEXTO DO PROJETO

**Empresa**: MC-COMERCIAL  
**Tipo**: Centro de Formação Profissional  
**Descrição**: Centro de formação de qualidade com mais de 10 anos de experiência na preparação de profissionais qualificados para o mercado de trabalho. Oferece cursos especializados em diversas áreas, disponíveis em modalidades presencial, online e híbrida.

---

## 🗄️ ESTRUTURA DE DADOS DO BACKEND

### Tabelas Principais:

#### 1. **CENTROS** (Centros de Formação)
```
- ID
- Nome (único)
- Localização (endereço)
- Contactos (array de telefones)
- Email
```

#### 2. **CURSOS** (Cursos Disponíveis)
```
- ID
- Nome
- Descrição detalhada
- Programa/Módulos
- Área (ex: Tecnologia, Administração, Vendas)
- Modalidade (presencial, online, híbrida)
- Imagem/URL da capa
- Status ativo/inativo
```

#### 3. **TURMAS** (Edições dos Cursos)
```
- ID
- Curso ID (relacionado a cursos)
- Centro ID (em qual centro será oferecida)
- Formador ID (professor responsável)
- Data de arranque
- Dias da semana (array: Seg-Sexta, Sábado, Domingo)
- Período (manhã, tarde, noite)
- Hora início e fim
- Vagas totais
- Vagas preenchidas
- Status (planeada, inscrições_abertas, em_andamento, concluída)
- **PUBLICADO (boolean - CAMPO CRÍTICO: mostrar APENAS turmas onde publicado=TRUE)**
```

#### 4. **FORMADORES** (Instrutores)
```
- ID
- Nome
- Email
- Contactos (array de telefones)
- Especialidade
- Biografia
- Foto (imagem do formador)
```

#### 5. **GRUPOS** (Categorias de Produtos/Serviços)
```
- ID
- Nome (ex: "produtos", "servicos")
- Display Name (ex: "Produtos", "Serviços")
- Ícone FontAwesome (ex: "fas fa-box", "fas fa-cogs")
- Ordem de exibição
```

#### 6. **CATEGORIAS** (Subcategorias)
```
- ID
- Nome
- Descrição
- Grupo ID (qual grupo pertence)
- Ordem
```

#### 7. **ITENS** (Produtos e Serviços)
```
- ID
- Nome
- Descrição
- Preço (decimal - NULL ou 0 = "Sob Consulta")
- Imagem/URL
- Categoria ID
- Tipo (produto ou serviço)
- Destaque (boolean - destacar no site)
- Ordem
```

#### 8. **PRÉ-INSCRIÇÕES** (Inscrições de Alunos)
```
- ID
- Turma ID
- Nome completo
- Email
- Contactos (array de telefones)
- Status (pendente, confirmado, cancelado)
- Observações
```

---

## 🎨 PÁGINAS E SEÇÕES OBRIGATÓRIAS

### 📱 01. PÁGINA INICIAL (Home)

#### Seções:
1. **Hero Section**
   - Banner principal com imagem/vídeo de fundo
   - Título principal: "Invista no seu Futuro Profissional"
   - Subtitle: "Formação de qualidade com mais de 10 anos de experiência"
   - 2 CTA Buttons:
     - "Explorar Cursos" (link para página de cursos)
     - "Saber Mais" (scroll para próxima seção)
   - Animação de entrada suave

2. **Estatísticas/Conquistas**
   - Card 1: "500+" Alunos Formados
   - Card 2: Contador dinâmico de "X Cursos Disponíveis" (fetch API)
   - Card 3: Contador dinâmico de "X Centros de Formação" (fetch API)
   - Card 4: "100%" Taxa de Sucesso
   - Animações ao scroll
   - Icons relacionados

3. **Centros de Formação (Preview)**
   - Cards dos 3 primeiros centros (ou todos se <4)
   - Cada card mostra:
     - Ícone/Logo do centro
     - Nome
     - Localização
     - Telefone (com link para telefonar)
     - Botão "Explorar"
   - Responsivo: 3 colunas desktop, 2 tablet, 1 mobile
   - Botão "Ver Todos os Centros" ao final

4. **Serviços da Empresa**
   - Grid 3x2 (6 cards de serviços):
     - Imagem/ícone
     - Título (ex: "Projectos Académicos", "Formação Profissional", "Workshops")
     - Descrição breve
     - Hover effect com overlay

5. **Turmas Disponíveis (Preview)**
   - Mostrar 6 primeiras turmas com `publicado=true`
   - Cada card com:
     - Imagem do curso
     - Nome do curso
     - Período (manhã/tarde/noite)
     - Data de arranque formatada
     - Vagas disponíveis (com badge)
     - Botão "Pré-inscrever-se"
   - Botão "Ver Todas as Turmas" ao final

6. **Newsletter/Email Subscribe**
   - Fundo gradiente
   - Título: "Fique Atualizado"
   - Descrição: "Subscreva a nossa newsletter para receber novidades"
   - Campo email + Botão subscribe
   - Animação suave

7. **Por que Escolher MC-COMERCIAL (CTA Final)**
   - 2 colunas:
     - Esquerda: Lista com checkmarks
       - ✓ Experiência Comprovada (10+ anos)
       - ✓ Cursos Especializados
       - ✓ Formadores Experientes
       - ✓ Certificações Reconhecidas
       - Botão "Saber Mais Sobre Nós"
     - Direita: Mapa Google Maps (Luanda Viana) ou embed de localização

---

### 📚 02. PÁGINA CURSOS/TURMAS

#### Estrutura:
- **Filtros Laterais (Sticky em desktop):**
  - Busca por nome (search input)
  - Filtro por Modalidade (radio buttons: Todas, Presencial, Online, Híbrida)
  - Filtro por Área (select dropdown - dinâmico)
  - Filtro por Centro (select dropdown - dinâmico)
  - Botão "Limpar Filtros"

- **Grid de Cursos/Turmas:**
  - Desktop: 2 colunas (grid-col-lg-6)
  - Tablet: 2 colunas
  - Mobile: 1 coluna
  - Agrupado por Curso (mostrar todas as turmas do mesmo curso juntas)
  
- **Card de Curso:**
  ```
  [Imagem do Curso - 220px altura]
         ↓
  ⭐ X Turmas
         ↓
  [Título do Curso]
  [Descrição curta - 100 chars máximo]
         ↓
  [Badge Área] [Badge Modalidade]
         ↓
  👥 Vagas: 25 de 50 [Barra de progresso]
         ↓
  [Botão "Ver Turmas Disponíveis"]
  ```

- **Modal ao Clicar em "Ver Turmas Disponíveis":**
  - Título: "Turmas - [Nome do Curso]"
  - Lista de turmas com:
    - Período
    - Data arranque
    - Horário (hh:mm - hh:mm)
    - Vagas disponíveis (badge)
    - Botão "Inscrever-se"

---

### 🎓 03. PÁGINA DETALHES DO CURSO (Novo - complementar)

#### Seções:
- **Hero com Imagem do Curso**
  - Imagem grande (hero section)
  - Breadcrumb: Home > Cursos > [Nome Curso]

- **Informações Principais:**
  - Título
  - Descrição completa
  - [Badge Área] [Badge Modalidade]
  - Programa/Módulos (se houver)

- **Cards de Informações:**
  - Duração
  - Número de turmas disponíveis
  - Requisitos

- **Formadores Associados:**
  - Cards com:
    - Foto do formador
    - Nome
    - Especialidade
    - Biografia
    - Contactos (email, telefone)

- **Turmas Disponíveis (Listagem Completa)**
  - Tabela ou cards com todas as turmas
  - Ordenado por data de arranque
  - Botão "Inscrever-se" em cada turma

---

### 🏢 04. PÁGINA CENTROS

#### Estrutura:
- **Mapa com Centros (se possível)**
  - Google Maps com markers de cada centro

- **Grid de Centros:**
  - Cards com:
    - Logo/Foto do centro
    - Nome
    - Localização completa
    - Telefone(s) (clickable tel: links)
    - Email (clickable mailto: links)
    - Horário de funcionamento
    - Cursos oferecidos neste centro
    - Botão "Ver Turmas Deste Centro"

---

### 🛍️ 05. PÁGINA PRODUTOS & SERVIÇOS

#### Estrutura:
- **Menu de Grupos (Tabs ou Sidebar):**
  - Cada grupo com seu ícone (ex: 📦 Produtos, 🔧 Serviços)

- **Categorias Dentro de Cada Grupo:**
  - Expandir/Colapsar
  - Mostrar itens da categoria

- **Grid de Itens:**
  - Cada item com:
    - Imagem do produto/serviço
    - Nome
    - Descrição
    - Preço (ou "Sob Consulta" se NULL)
    - Badge "Destaque" se aplicável
    - Botão "Solicitar" ou "Contactar"

---

### 📞 06. PÁGINA CONTACTOS

#### Seções:
1. **Formulário de Contacto**
   - Nome completo
   - Email
   - Telefone
   - Assunto (select: Geral, Cursos, Produtos, Serviços)
   - Mensagem (textarea)
   - Botão Enviar
   - Validação frontend + backend

2. **Sobre a Empresa**
   - Breve histórico (10+ anos)
   - Missão e visão

3. **Informações de Contacto**
   - Telefones (com ícone de telefone - links em tel:)
   - Email (com ícone de envelope - links em mailto:)
   - Localização
   - Links de redes sociais (Facebook, Instagram, LinkedIn, YouTube)

4. **Horário de Funcionamento**
   - Segunda - Sexta: 8h00 - 18h00
   - Sábado: 9h00 - 16h00
   - Domingo: Encerrado

5. **Botões de Contacto Rápido**
   - WhatsApp (flutuante ou na página)
   - Facebook (link/link para messenger)
   - Email (mailto:)
   - Telefone (tel:)

---

### 📖 07. PÁGINA SOBRE NÓS

#### Seções:
1. **História da Empresa**
   - Texto sobre os 10+ anos
   - Marcos importantes

2. **Valores e Missão**
   - Missão
   - Visão
   - Valores

3. **Equipa/Formadores Destaque**
   - Cards com:
     - Foto
     - Nome
     - Cargo/Especialidade
     - Bio curta

4. **Parceiros/Certificações**
   - Logos de parceiros
   - Certificações obtidas

---

### 📱 08. COMPONENTES GLOBAIS

#### Header/Navbar:
- **Top Bar (antes do navbar):**
  - 📧 Email: mucuanha.chineva@gmail.com
  - 📞 Telefone: +244 929-643-510
  - 🕒 Horário: Seg - Sex: 9h00 - 18h00
  - Fundo escuro

- **Main Navbar:**
  - Logo + nome "MC-COMERCIAL" (esquerda)
  - Menu central:
    - Home
    - Centros
    - Cursos
    - Sobre Nós
    - Contactos
  - Botão "Login" (direita)
  - Hamburger menu em mobile
  - Navbar sticky ao scroll com sombra

#### Footer:
- **4 Colunas:**
  1. Logo + About (150 chars)
     - Links Sociais (Facebook, Instagram, LinkedIn, YouTube)
  2. Links Rápidos (Home, Centros, Sobre, Contactos)
  3. Contactos (Email, Telefone, Endereço)
  4. Horário + Botão Login
- **Copyright:**
  - © 2024 MC-COMERCIAL. Todos os direitos reservados.

#### Botão WhatsApp Flutuante:
- Posição: Canto inferior direito (fixed)
- Link: `https://wa.me/244929643510?text=Olá%2C%20gostaria%20de%20saber%20mais%20sobre%20os%20cursos%20da%20MC-COMERCIAL`
- Ícone WhatsApp
- Hover effect com elevação
- Animação suave (float)

#### Modais:
1. **Modal Pré-Inscrição em Turma**
   - Campos:
     - Nome completo (obrigatório)
     - Email (obrigatório, validar formato)
     - Telefone (opcional, validar se preenchido)
     - Checkbox: "Concordo com os termos e condições" (obrigatório)
   - Botões: Inscrever-se | Cancelar
   - Validação completa antes de enviar

2. **Modal Contacto (Formulário)**
   - Nome completo
   - Email
   - Telefone
   - Mensagem
   - Validação e envio para backend

---

## 🎨 DESIGN & UX REQUIREMENTS

### Paleta de Cores:
```
Primário: #1e3a8a (Azul profundo)
Secundário: #334155 (Cinzento escuro)
Accent: #3b82f6 (Azul claro)
Light Gray: #f1f5f9
Dark Gray: #475569
Sucesso: #16a34a (Verde)
Aviso: #ca8a04 (Amarelo/Laranja)
Erro: #dc2626 (Vermelho)
```

### Tipografia:
- Fonte: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
- Títulos (H1): 3.5rem, bold
- Títulos Seções: 2.5rem, bold
- Corpo: 1rem, line-height 1.6

### Componentes:
1. **Cards:**
   - Sombra suave (0 4px 20px rgba(0,0,0,0.08))
   - Border-radius: 1rem
   - Hover: Elevação com transform translateY(-10px)
   - Transição suave 0.3s

2. **Botões:**
   - Primário: Gradiente #3b82f6 → #2563eb
   - Outline: Sem fundo, apenas border
   - Hover: Escurecer + elevação
   - Padding: 0.75rem 2rem
   - Border-radius: 0.5rem
   - Font-weight: 600
   - Cursor: pointer

3. **Inputs/Selects:**
   - Border: 1px solid #cbd5e1
   - Border-radius: 0.5rem
   - Padding: 0.75rem 1rem
   - Focus: Border #3b82f6 + sombra azul
   - Transição 0.3s

4. **Badges:**
   - Padding: 0.5rem 0.75rem
   - Border-radius: 0.375rem
   - Font-weight: 600
   - Diferentes cores por tipo

### Animações:
- **Fade In Up:** Elementos entram com opacidade 0 → 1 + translateY(30px) → 0
- **Slide In (Left/Right):** Elementos entram lateralmente
- **Float:** Botões flutuam continuamente
- **Pulse:** Loaders e elementos destacados
- **Todas com:** duration 0.6s, easing ease-out

### Responsividade:
- **Desktop:** 1200px+
- **Tablet:** 768px - 1199px
- **Mobile:** < 768px
- Breakpoints Bootstrap: lg, md, sm, xs
- Mobile first approach

---

## ⚙️ FUNCIONALIDADES

### 1. Filtros em Tempo Real (Cursos)
```
EVENTO: Usuário modifica filtros
AÇÃO: 
  - Filtrar cursos por modalidade (presencial/online/híbrida)
  - Filtrar por área
  - Filtrar por centro
  - Buscar por nome
  - Combinar múltiplos filtros
RESULTADO: Grid atualizado com animação
```

### 2. Pré-Inscrição em Turma
```
EVENTO: Usuário clica "Inscrever-se"
AÇÃO:
  - Abre modal com formulário
  - Valida campos (nome, email, telefone, termos)
  - Envia POST /api/pre-inscricoes
RESPOSTA:
  - Toast de sucesso "Pré-inscrição realizada!"
  - Fecha modal
  - Verifique seu email para confirmação
ERRO:
  - Toast de erro com mensagem específica
```

### 3. Contacto via Formulário
```
EVENTO: Usuário envia formulário contacto
AÇÃO:
  - Valida todos campos
  - Envia POST /api/contactos
RESPOSTA:
  - Toast sucesso
  - Limpa formulário
  - Email enviado para admin
```

### 4. Integração WhatsApp
```
- Link WhatsApp flutuante
- Pré-preenchido: "Olá, gostaria de saber mais sobre os cursos da MC-COMERCIAL"
- Abre WhatsApp Web/App ao clicar
```

### 5. Redes Sociais
```
- Facebook: Link para página (a definir)
- Instagram: Link para perfil (a definir)
- LinkedIn: Link para empresa (a definir)
- YouTube: Link para canal (a definir)
```

### 6. Performance & Otimizações
```
- Lazy loading de imagens
- Code splitting por página
- Minificação CSS/JS
-Compressão de imagens
- Cache de dados (localStorage para filtros)
- Preload de fontes críticas
- Debounce em filtros de busca
```

### 7. SEO Básico
```
- Meta tags (description, keywords, og:image, og:title)
- Breadcrumbs estruturados (schema.org)
- Sitemap XML
- Robots.txt
- Heading hierarchy correto (H1, H2, H3)
- Alt text em todas as imagens
```

---

## 📡 INTEGRAÇÃO COM BACKEND

### Endpoints API Necessários:

```
GET /cursos
- Retorna: Array de cursos com fields [id, nome, descricao, area, modalidade, imagem_url, ativo]

GET /centros
- Retorna: Array de centros com fields [id, nome, localizacao, contactos, email]

GET /turmas?publicado=true
- Retorna: Array de turmas com relationships [curso, centro, formador]
- Filtro: WHERE publicado = true
- Ordered by: data_arranque ASC

GET /turmas/:id/detalhe
- Retorna: Turma completa com TODAS as informações incluindo formadores

GET /formadores
- Retorna: Array de formadores [id, nome, especialidade, bio, foto_url, contactos]

GET /itens
- Retorna: Array de itens com relationships [categoria → grupo]
- Organizados por grupo/categoria

GET /grupos
- Retorna: Array de grupos com ordem

POST /api/pre-inscricoes
- Body: { turma_id, nome_completo, email, contactos[phones], status='pendente' }
- Retorna: { success, message, id }

POST /api/contactos
- Body: { nome, email, telefone, assunto, mensagem }
- Retorna: { success, message }
```

### Headers Necessários:
```
- Accept: application/json
- X-Requested-With: XMLHttpRequest
- X-CSRF-TOKEN: (do meta tag csrf-token no HTML)
```

---

## 🚀 REQUISITOS TÉCNICOS - LARAVEL + BLADE

### Stack Tecnológico:
- **Backend:** PHP 8.1+ com Laravel 10+
- **Frontend:** Blade Templates (Laravel templating engine) - SEM React/Vue
- **CSS Framework:** Bootstrap 5.3+
- **JavaScript:** Vanilla JS (separado em módulos)
- **Build Tool:** Vite (hot reload em desenvolvimento)
- **Package Manager:** npm

---

## 📁 ESTRUTURA DE ARQUIVOS JAVASCRIPT (SEPARADO)

### ✅ Organização Recomendada:

```
resources/
├── js/
│   ├── app.js                    # ⭐ Entry point (imports globais)
│   ├── modules/
│   │   ├── api.js                # Requisições HTTP
│   │   ├── validacoes.js         # Validações de formulários
│   │   ├── animations.js         # Animações e efeitos
│   │   ├── modal.js              # Modais reutilizáveis
│   │   └── filters.js            # Filtros de cursos
│   │
│   └── pages/
│       ├── home.js               # Scripts específicos da home
│       ├── cursos.js             # Scripts específicos de cursos
│       ├── centros.js            # Scripts específicos de centros
│       ├── produtos.js           # Scripts específicos de produtos
│       └── contactos.js          # Scripts específicos de contactos
│
└── css/
    ├── app.css                   # CSS global + variáveis
    └── components.css            # Componentes reutilizáveis
```

### 🔧 Vite Config - Configuração de Build:

**vite.config.js:**
```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                // Módulos específicos por página (optional - se cada página precisar)
                'resources/js/pages/home.js',
                'resources/js/pages/cursos.js',
            ],
            refresh: true,
        }),
    ],
});
```

---

## 📝 ESTRUTURA DE ARCHIVOS BLADE

### Layout Principal (`resources/views/layouts/public.blade.php`):

```blade
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - MC-COMERCIAL</title>
    
    {{-- 🔥 Vite: Compilação automática de CSS + JS global --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Header/Navbar -->
    <header class="main-header">
        <!-- ... navbar content ... -->
    </header>

    <!-- Main Content (cada página estende aqui) -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <!-- ... footer content ... -->
    </footer>

    <!-- WhatsApp Button Flutuante -->
    <a href="https://wa.me/244929643510" class="whatsapp-btn">
        <i class="fab fa-whatsapp"></i>
    </a>

    {{-- Scripts globais já carregados via @vite acima --}}
    {{-- Cada página pode carregar um JS específico --}}
    @yield('page-scripts')
</body>
</html>
```

---

## 📄 Exemplo: View Home (`resources/views/site/home.blade.php`):

```blade
@extends('layouts.public')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <h1 class="hero-title">Invista no seu Futuro Profissional</h1>
                    <p class="hero-subtitle">Formação de qualidade com mais de 10 anos de experiência</p>
                    <div class="hero-cta">
                        <a href="{{ route('site.cursos') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Explorar Cursos
                        </a>
                        <a href="#sobre-nós" class="btn btn-outline-light">
                            <i class="fas fa-info-circle me-2"></i>Saber Mais
                        </a>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <img src="{{ asset('images/banner-11.jpg') }}" alt="Formação" class="img-fluid rounded-3">
                </div>
            </div>
        </div>
    </section>

    <!-- Estatísticas -->
    <section class="section">
        <div class="container">
            <h2 class="section-title text-center">Nossas Conquistas</h2>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card feature-card">
                        <h3 class="text-gradient">500+</h3>
                        <p class="text-muted">Alunos Formados</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card feature-card">
                        <h3 class="text-gradient" id="total-cursos">-</h3>
                        <p class="text-muted">Cursos Disponíveis</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card feature-card">
                        <h3 class="text-gradient" id="total-centros">-</h3>
                        <p class="text-muted">Centros de Formação</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card feature-card">
                        <h3 class="text-gradient">100%</h3>
                        <p class="text-muted">Taxa de Sucesso</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ... mais seções ... -->

@endsection

{{-- 🎯 Carregar JS específico desta página (SEPARADO) --}}
@section('page-scripts')
    @vite(['resources/js/pages/home.js'])
@endsection
```

---

## 🧩 Módulos JavaScript Separados

### 1️⃣ **app.js** (Entry Point Global):

```javascript
// resources/js/app.js

// Importar módulos
import { setupCSRFToken, initAOS, setupHeaderScroll, setupSmoothScroll } from './modules/animations.js';
import * as API from './modules/api.js';
import * as Validacoes from './modules/validacoes.js';

// Expor globalmente (para Blade usar se necessário)
window.API = API;
window.Validacoes = Validacoes;
window.showToast = showToast;
window.showError = showError;

// Inicialização Global
document.addEventListener('DOMContentLoaded', () => {
    setupCSRFToken();
    initAOS();
    setupHeaderScroll();
    setupSmoothScroll();
    
    console.log('✅ App iniciado com sucesso');
});

// Toast Notification (reutilizável)
function showToast(message, type = 'success') {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: type,
        title: message,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
}

function showError(message) {
    showToast(message, 'error');
}
```

### 2️⃣ **modules/api.js** (Requisições HTTP):

```javascript
// resources/js/modules/api.js

export async function apiRequest(url, options = {}) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    
    const defaultHeaders = {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    };
    
    if (csrfToken) {
        defaultHeaders['X-CSRF-TOKEN'] = csrfToken;
    }

    try {
        const response = await fetch(url, {
            ...options,
            headers: { ...defaultHeaders, ...options.headers }
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        return await response.json();
    } catch (error) {
        console.error('❌ API Error:', error);
        throw error;
    }
}

export async function getCursos() {
    return apiRequest('/api/cursos');
}

export async function getCentros() {
    return apiRequest('/api/centros');
}

export async function getTurmas(filtros = {}) {
    const params = new URLSearchParams({ publicado: true, ...filtros });
    return apiRequest(`/api/turmas?${params}`);
}

export async function getGrupos() {
    return apiRequest('/api/grupos');
}

export async function submitPreInscricao(data) {
    return apiRequest('/api/pre-inscricoes', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });
}

export async function submitContacto(data) {
    return apiRequest('/api/contactos', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });
}
```

### 3️⃣ **modules/validacoes.js** (Validações Reutilizáveis):

```javascript
// resources/js/modules/validacoes.js

export function validarEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

export function validarTelefone(telefone) {
    return !telefone || /^\+?[0-9]{9,13}$/.test(telefone);
}

export function validarNome(nome) {
    return nome && nome.trim().length > 0 && nome.length <= 255;
}

export function validarMensagem(msg) {
    return msg && msg.trim().length > 0 && msg.length <= 1000;
}

export function validarFormularioPreInscricao(formData) {
    const erros = [];
    
    if (!validarNome(formData.nome_completo)) {
        erros.push('Nome inválido');
    }
    
    if (!validarEmail(formData.email)) {
        erros.push('Email inválido');
    }
    
    if (!validarTelefone(formData.telefone)) {
        erros.push('Telefone inválido');
    }
    
    if (!formData.concordo) {
        erros.push('Deve aceitar os termos');
    }
    
    return erros.length === 0 ? { valido: true } : { valido: false, erros };
}
```

### 4️⃣ **modules/animations.js** (Animações Globais):

```javascript
// resources/js/modules/animations.js

export function setupCSRFToken() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}

export function initAOS() {
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        offset: 100
    });
}

export function setupHeaderScroll() {
    const header = document.querySelector('.main-header');
    if (!header) return;
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
}

export function setupSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            e.preventDefault();
            const target = document.querySelector(anchor.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
}
```

### 5️⃣ **pages/home.js** (Scripts da Página Home - SEPARADO):

```javascript
// resources/js/pages/home.js

// Importar funções do módulo API
import { getCursos, getCentros, getTurmas } from '../modules/api.js';
import { showError } from '../app.js';

// Scripts específicos da home
async function carregarEstatisticas() {
    try {
        const cursos = await getCursos();
        const centros = await getCentros();
        
        const totalCursos = Array.isArray(cursos) ? cursos.length : cursos.data?.length || 0;
        const totalCentros = Array.isArray(centros) ? centros.length : centros.data?.length || 0;
        
        document.getElementById('total-cursos').textContent = totalCursos;
        document.getElementById('total-centros').textContent = totalCentros;
    } catch (error) {
        console.error('Erro ao carregar estatísticas:', error);
        showError('Erro ao carregar estatísticas');
    }
}

async function carregarCentros() {
    try {
        const centros = await getCentros();
        const centrosArray = Array.isArray(centros) ? centros : centros.data || [];
        
        // Renderizar apenas os 3 primeiros
        const container = document.getElementById('centros-preview');
        if (!container) return;
        
        container.innerHTML = centrosArray.slice(0, 3).map(centro => `
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-building"></i>
                        </div>
                        <h5>${centro.nome}</h5>
                        <p class="text-muted small">${centro.localizacao}</p>
                        <a href="{{ route('site.centros') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-arrow-right me-1"></i>Explorar
                        </a>
                    </div>
                </div>
            </div>
        `).join('');
        
        AOS.refresh();
    } catch (error) {
        console.error('Erro ao carregar centros:', error);
    }
}

async function carregarTurmas() {
    try {
        const turmas = await getTurmas({ per_page: 6 });
        const turmasArray = Array.isArray(turmas) ? turmas : turmas.data || [];
        
        // Renderizar turmas...
        const container = document.getElementById('turmas-preview');
        if (!container) return;
        
        container.innerHTML = turmasArray.map(turma => `
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="card h-100">
                    <!-- Card content -->
                </div>
            </div>
        `).join('');
        
        AOS.refresh();
    } catch (error) {
        console.error('Erro ao carregar turmas:', error);
    }
}

// Executar ao carregar página
document.addEventListener('DOMContentLoaded', () => {
    carregarEstatisticas();
    carregarCentros();
    carregarTurmas();
});
```

### 6️⃣ **pages/cursos.js** (Scripts da Página Cursos - SEPARADO):

```javascript
// resources/js/pages/cursos.js

import { getTurmas } from '../modules/api.js';
import { showError } from '../app.js';

async function aplicarFiltros() {
    const busca = document.getElementById('filtro-busca')?.value || '';
    const modalidade = document.querySelector('input[name="modalidade"]:checked')?.value || '';
    
    try {
        const turmas = await getTurmas({
            search: busca,
            modalidade: modalidade,
        });
        
        renderizarTurmas(turmas);
    } catch (error) {
        showError('Erro ao aplicar filtros');
    }
}

function renderizarTurmas(turmas) {
    // Lógica para renderizar turmas...
}

// Event Listeners
document.addEventListener('DOMContentLoaded', () => {
    const filtros = document.querySelectorAll('[data-filter]');
    filtros.forEach(filtro => {
        filtro.addEventListener('change', aplicarFiltros);
    });
});
```

---

## 🔄 Fluxo de Compilação (Vite):

```bash
# Terminal 1: Watch mode (hot reload)
npm run dev

# Terminal 2: Servidor Laravel
php artisan serve

# Em produção:
npm run build
```

### Resultado dos arquivos compilados:
```
public/build/
├── resources/
│   ├── css/app-HASH.css
│   └── js/app-HASH.js
│   └── js/pages/home-HASH.js
└── manifest.json
```

---

## ✅ Vantagens desta Estrutura:

---

## ✅ Vantagens desta Estrutura:

1. **✅ JavaScript Completamente Separado**
   - Nenhum código inline nas views Blade
   - Arquivo Blade = apenas HTML/PHP
   - Arquivo JS = apenas JavaScript

2. **✅ Reutilização de Código**
   - Funções em `modules/` usadas por múltiplas páginas
   - Padrão DRY (Don't Repeat Yourself)

3. **✅ Fácil Manutenção**
   - Cada página tem seu próprio arquivo JS
   - Lógica bem organizada e separada
   - Fácil debugar

4. **✅ Performance**
   - Vite faz minificação automática
   - Tree-shaking (remove código não usado)
   - Hot reload em desenvolvimento

5. **✅ Escalabilidade**
   - Adicionar páginas ou funcionalidades é simples
   - Não há "spaghetti code"

---

## 🌍 Endpoints API Necessários:

```bash
GET /api/cursos
GET /api/centros
GET /api/turmas?publicado=true&per_page=6
GET /api/grupos
GET /api/categorias
GET /api/itens
POST /api/pre-inscricoes
POST /api/contactos
```

---

## 🛠️ Setup do Projeto (Passo a Passo):

```bash
# 1. Clonar/Acessar projeto Laravel
cd seu-projeto-laravel

# 2. Instalar dependências npm
npm install

# 3. Copiar arquivos JS para resources/js/
# (Quando receber código gerado do AI)

# 4. Copiar arquivos Blade para resources/views/
# (Quando receber código gerado do AI)

# 5. Terminal 1: Iniciar Vite (hot reload)
npm run dev

# 6. Terminal 2: Iniciar Laravel
php artisan serve

# 7. Acessar em http://127.0.0.1:8000/site

# Produção:
npm run build
```

---

## 📋 Arquivos a Gerar com AI:

### 🎨 Blade Views (HTML + PHP) - 8 Arquivos:
1. `resources/views/site/home.blade.php` - Página inicial
2. `resources/views/site/cursos.blade.php` - Listagem de cursos
3. `resources/views/site/centros.blade.php` - Listagem de centros
4. `resources/views/site/centro-detalhe.blade.php` - Centro individual
5. `resources/views/site/produtos-servicos.blade.php` - Produtos e serviços
6. `resources/views/site/contactos.blade.php` - Página de contato
7. `resources/views/site/sobre.blade.php` - Sobre a empresa
8. `resources/layouts/public.blade.php` - Layout mestre (se não existir)

### 🔧 JavaScript Modules - 10 Arquivos:
1. `resources/js/app.js` - Entry point global
2. `resources/js/modules/api.js` - Wrapper para fetch/requests
3. `resources/js/modules/validacoes.js` - Funções de validação
4. `resources/js/modules/animations.js` - Animações globais
5. `resources/js/modules/modal.js` - Controle de modais
6. `resources/js/modules/filters.js` - Filtros de cursos
7. `resources/js/pages/home.js` - Scripts específicos home
8. `resources/js/pages/cursos.js` - Scripts específicos cursos
9. `resources/js/pages/centros.js` - Scripts específicos centros
10. `resources/js/pages/contactos.js` - Scripts específicos contactos

### ⚙️ Vite Config (Já Deve Existir):
- `vite.config.js` - Configurar múltiplos entry points (app.js + pages/*)

### 💾 Total: 18 Novos Arquivos

---

## 📋 CHECKLIST DE ENTREGA

### Página Inicial (Home):
- ✅ Hero section com CTA
- ✅ Estatísticas (com contadores dinâmicos)
- ✅ Preview centros com links
- ✅ Grid serviços
- ✅ Preview turmas (6 primeiras)
- ✅ Newsletter signup
- ✅ CTA final com mapa

### Página Cursos:
- ✅ Filtros funcionais (modalidade, área, centro, search)
- ✅ Grid responsivo agrupado por curso
- ✅ Modal com turmas disponíveis
- ✅ Botão inscrição em cada turma
- ✅ Loading states

### Página Centros:
- ✅ Cards com informações completas
- ✅ Links de contacto clicáveis
- ✅ Opção de ver turmas do centro
- ✅ Mapa (opcional)

### Página Produtos & Serviços:
- ✅ Organização por grupos
- ✅ Subcategorias
- ✅ Grid de itens com imagens
- ✅ Preços ou "Sob Consulta"
- ✅ Botão contacto

### Página Contactos:
- ✅ Formulário com validação
- ✅ Fields: nome, email, telefone, assunto, mensagem
- ✅ Informações de contacto (tel, email, endereço)
- ✅ Horários
- ✅ Links sociais
- ✅ Botão WhatsApp

### Página Sobre Nós:
- ✅ História (10+ anos)
- ✅ Valores/Missão
- ✅ Equipa destaque

### Componentes Globais:
- ✅ Header com navbar sticky
- ✅ Footer com 4 colunas + copyright
- ✅ Botão WhatsApp flutuante
- ✅ Modal pré-inscrição com validação
- ✅ Modal contacto
- ✅ Notificações toast (sucesso/erro)

### Responsividade:
- ✅ Desktop (1200px+)
- ✅ Tablet (768px - 1199px)
- ✅ Mobile (< 768px)
- ✅ Testes em Chrome DevTools
- ✅ Testes em dispositivos reais

### Animações & UX:
- ✅ Transições suaves
- ✅ Hover effects em cards/botões
- ✅ Loading spinners
- ✅ AOS (Animate on Scroll)
- ✅ Scroll comportamento suave

### Performance:
- ✅ Lazy loading de imagens
- ✅ Minificação CSS/JS
- ✅ Otimização de imagens
- ✅ Lighthouse score > 90
- ✅ PageSpeed Insights > 80

### SEO:
- ✅ Meta tags dinâmicas
- ✅ Sitemap XML
- ✅ Robots.txt
- ✅ Schema.org estruturado
- ✅ Alt text em imagens
- ✅ Heading hierarchy

### Acessibilidade:
- ✅ WCAG 2.1 Level AA
- ✅ Contrast ratios OK
- ✅ Keyboard navigation
- ✅ ARIA labels
- ✅ Screen reader friendly

---

## 🎯 OBSERVAÇÕES IMPORTANTES

### Dados Críticos:
1. **PUBLICADO=TRUE:** Mostrar APENAS turmas onde `publicado=true`. Turmas não publicadas não aparecem no site público.
2. **Relacionamentos:** 
   - Turma → Curso → Área/Modalidade
   - Turma → Centro → Localização/Contactos
   - Turma → Formador → Bio/Especialidade
   - Itens → Categoria → Grupo
3. **Preço:** Se NULL ou 0, exibir "Sob Consulta"
4. **Vagas:** Calcular dinâmicamente: vagas_disponíveis = vagas_totais - vagas_preenchidas

### Validações Frontend:
1. Email: Validar formato padrão (xxx@xxx.xxx)
2. Telefone: Validar apenas se preenchido (9-13 dígitos com + opcional)
3. Nome: Não vazio, máx 255 chars
4. Mensagem: Não vazio, máx 1000 chars
5. Termos: Obrigatório (checkbox marcado)

### Endpoints Esperados:
```
POST /api/pre-inscricoes (Auth opcional, referrer pode ser pública)
POST /api/contactos (Sem auth necessária)

GET endpoints:
- /cursos
- /centros
- /turmas?publicado=true
- /grupos
- /categorias
- /itens
- /formadores
```

### Configurações de Email (Backend):
- Notificação de pré-inscrição para admin
- Confirmação de contacto para usuário
- Enviar a: mucuanha.chineva@gmail.com

### Informações de Contacto (Fixas):
- Email: mucuanha.chineva@gmail.com
- Telefone 1: +244 929-643-510
- Telefone 2: +244 928-966-002
- Endereço: Rua A, Bairro 1º de Maio Nº 05, 1º Andar, Luanda-Viana
- Horário: Seg-Sexta 8h-18h, Sábado 9h-16h, Domingo Encerrado
- WhatsApp: +244929643510

---

## 📞 INFORMAÇÕES ADICIONAIS

**Localização Empresa:** Luanda, Viana, Angola  
**Experiência:** 10+ anos em formação profissional  
**Objetivo:** Posicionar-se como referência em formação profissional e venda de produtos/serviços  
**Target:** Empresas, indivíduos e instituições que buscam formação profissional

---

## ✨ ESTE É UM PROMPT PROFISSIONAL COMPLETO PRONTO PARA USAR COM QUALQUER AI

Basta copiar este arquivo inteiro e colar em:
- **Claude** (Anthropic)
- **ChatGPT** (OpenAI)
- **Gemini** (Google)
- **Copilot** (Microsoft)
- Ou qualquer outro AI generativo com capacidade de gerar código
