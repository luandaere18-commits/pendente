# 🎨 MC-COMERCIAL - Brief para Lovable

Copie e cole este texto NO LOVABLE:

---

## 📋 CONTEXTO DO PROJETO

Sou desenvolvedor trabalhando em **MC-COMERCIAL**, um site de centro de formação profissional em Angola.

**Stack Atual:**
- Backend: Laravel 10 + PHP 8.2
- Frontend: Blade + Tailwind CSS v3 + Alpine.js
- Database: MySQL

**Situação:**
- ✅ Todas as 6 páginas públicas já existem em Blade
- ✅ Layout principal (`layouts/public.blade.php`) pronto
- ✅ Componentes reutilizáveis (navbar, footer, etc) prontos
- ✅ Tailwind CSS com tema customizado pronto
- ❌ Precisa de ajustes e melhorias na estrutura

**Objetivo:**
Analisar os arquivos Blade do projeto e sugerir/implementar melhorias para garantir a melhor UX/UI possível, mantendo Blade como frontend (sem React).

---

## 📁 ESTRUTURA DE ARQUIVOS

### Views Principais (`resources/views/pages/`)
- `home.blade.php` - Hero carousel + stats + preview centros + turmas
- `centros.blade.php` - Lista de centros + mapa Google Maps
- `cursos.blade.php` - Catálogo com filtros dinâmicos
- `sobre.blade.php` - História + missão/visão + valores + equipa
- `contactos.blade.php` - Formulário de contacto
- `loja.blade.php` - Produtos e serviços (PRECISA SEPARAR!)

### Componentes (`resources/views/partials/`)
- `navbar.blade.php` - Menu fixo com logo + navegação
- `footer.blade.php` - Rodapé com links e info
- `topbar.blade.php` - Barra superior contactos
- `whatsapp.blade.php` - Botão WhatsApp flutuante
- `pre-inscricao-modal.blade.php` - Modal de pré-inscrição

### Styling
- `resources/css/app.css` - Tailwind + custom classes
- `tailwind.config.js` - Config tema
- `vite.config.js` - Config build

---

## 🎯 O QUE PRECISA FAZER

### 1. SEPARAÇÃO LOJA vs SERVIÇOS

A página `loja.blade.php` mistura 2 conceitos:
- **Loja**: Snackbar + Produtos (coisas que vendem)
- **Serviços**: Serviços de formação (consultoria, workshops, etc)

**Solução:**
- Criar `serviços.blade.php` (novo) - Serviços de formação
- Manter `loja.blade.php` - Apenas snackbar + produtos
- Adicionar rota `/site/serviços` em `routes/web.php`
- Atualizar navbar para incluir "Serviços"

### 2. MELHORIAS ESTRUTURAIS

- ✅ Verificar responsividade mobile das páginas
- ✅ Garantir acessibilidade (alt text, labels, etc)
- ✅ Otimizar performance (lazy loading, etc)
- ✅ Validar formulários (contacto, pré-inscrição)
- ✅ Melhorar UX dos filtros (cursos.blade.php)
- ✅ Carousel (home) com funcionalidades completas

### 3. CONSISTÊNCIA VISUAL

- Verificar se todas as páginas seguem o mesmo padrão
- Garantir spacing, tipografia, cores consistentes
- Revisar componentes (cards, buttons, inputs)

---

## 🎨 DESIGN TOKENS

### Logo e Branding
- **Logo Oficial**: `public/images/logo.png`
- **Local no Site**: NavBar, Footer, Home hero
- **Cores Primárias (do Logo)**:
  - Azul escuro: `#3A4BA5`
  - Branco: `#FFFFFF`
  - Usar em botões primários e destaques

### Cores Palette
```
Primary (Azul Escuro):     #3A4BA5
Accent (Azul Claro):       #3BA9FF  
Secondary (Branco):        #FFFFFF
Background:                #F8FAFB
Foreground:                #1F2937
Muted:                     #F3F4F6
```

### Tipografia
- Font: Plus Jakarta Sans
- H1/H2: Bold, cores foreground/gradient
- Body: Regular 14-16px, cor muted-foreground

### Componentes
- `feature-card` - Card padrão com sombra
- `section-title` - Título h1 com subtitle
- `badge-area` / `badge-modalidade` - Tags
- `gradient-text` - Texto com gradient (accent)

### Logo no Site
- **NavBar**: Logo.png à esquerda + nome "MC-COMERCIAL"
- **Home Hero**: Logo maior no fundo ou como ícone
- **Footer**: Logo + contactos
- **Tamanho**: 40-60px NavBar, 200px+ em seções principais

---

## � IMAGENS E GESTÃO DE ASSETS

### Imagens Atual
- ✅ Logo: `public/images/logo.png` (usar em navbar/footer)
- ✅ Banners: `public/images/banner-*.jpg` (hero sections)
- ❌ Imagens de cursos/turmas (produtos da loja)
- ❌ Fotos dos formadores
- ❌ Certificações/Parcerias

### Configuração de Armazenamento
**SOLICITAR AO LOVABLE:**
1. Avaliar `public/images/logo.png` e extrair cores exatas
2. Sugerir configuração para upload de imagens na loja (S3, Supabase, etc)
3. Implementar lazy loading em todas as imagens
4. Otimizar para WebP com fallback JPG
5. Garantir image responsiveness com srcset

### Estrutura Recomendada
```
public/images/
├── logo.png (MARCA PRINCIPAL)
├── banners/
│   ├── banner-1.jpg (home)
│   ├── banner-2.jpg (cursos)
│   └── ...
├── categorias/
│   ├── snacks.jpg
│   └── materiais.jpg
└── formadores/
    ├── foto-1.jpg
    └── ...

storage/app/uploads/ (para user-generated)
├── logo-uploaded/
├── produtos/
└── certificados/
```

---

## �📊 DADOS DISPONÍVEIS

### Backend (SiteController.php)
Todas as páginas recebem dados do `SiteController`:

```php
// HOME
$centros, $cursos, $turmas

// CENTROS
$centros, $turmas, $cursos

// CURSOS
$turmas, $areas

// SOBRE
$formadores

// LOJA
$grupos, $categorias, $itens

// CONTACTOS
Nenhum (apenas formulário)
```

---

## ⚠️ PROBLEMAS CONHECIDOS

(Se houver algum, mencione aqui)

---

## 🚀 PRÓXIMOS PASSOS

1. ✅ Analisar cada página Blade
2. ✅ Sugerir melhorias estruturais
3. ✅ Criar `serviços.blade.php` separado
4. ✅ Atualizar rotas e navbar
5. ✅ Testar responsividade
6. ✅ Garantir acessibilidade

---

## 📞 CONTACTO COM DADOS REAIS

- Email: contato@mc-comercial.ao
- Telefone: +244 222 123 456
- Localização: Luanda, Angola

---

**Link GitHub do projeto:**
https://github.com/SEU-USUARIO/Pendentes

(Se não tiver repositório GitHub ainda, execute as instruções em `GITHUB_SETUP.md`)
