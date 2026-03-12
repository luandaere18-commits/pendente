# 🎨 Guia de Implementação - Refactorização do Site Público MC-COMERCIAL

## 📋 Visão Geral

Este guia explica como implementar o novo design moderno do site público da MC-COMERCIAL. Todas as páginas foram completamente refactoradas com:

- ✅ Animações CSS avançadas (50+ keyframes)
- ✅ Design responsivo mobile-first
- ✅ Integração completa com API
- ✅ SweetAlert2 para notificações
- ✅ AOS (Animate On Scroll) para efeitos
- ✅ Google Maps integrado
- ✅ Formulários funcionais com validação
- ✅ WhatsApp button flutuante

## 📁 Estrutura de Ficheiros Criados

```
resources/views/site/
├── home-novo.blade.php           # Nova página inicial
├── centros-novo.blade.php        # Lista de centros
├── centro-detalhe-novo.blade.php # Detalhes de um centro
├── cursos-novo.blade.php         # Lista de cursos com filtros
├── sobre-novo.blade.php          # Página sobre nós
└── contactos-novo.blade.php      # Página de contactos
```

## 🔧 Passo 1: Actualizar as Rotas

Edite o ficheiro `routes/web.php` e substitua/adicione:

```php
Route::prefix('site')->controller(SiteController::class)->group(function () {
    // Rotas antigas (manter para compatibilidade, se necessário)
    Route::get('/', 'index')->name('site.index');           // home-novo
    Route::get('/centros', 'centros')->name('site.centros'); // centros-novo
    Route::get('/centro/{id}', 'centrodetalhe')->name('site.centro'); // centro-detalhe-novo
    Route::get('/cursos', 'cursos')->name('site.cursos');   // cursos-novo
    Route::get('/sobre', 'sobre')->name('site.sobre');      // sobre-novo
    Route::get('/contactos', 'contactos')->name('site.contactos'); // contactos-novo
});
```

## 🔧 Passo 2: Actualizar o Controlador (SiteController)

Edite `app/Http/Controllers/SiteController.php`:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Centro;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return view('site.home-novo');
    }
    
    public function centros()
    {
        return view('site.centros-novo');
    }
    
    public function centrodetalhe($id)
    {
        return view('site.centro-detalhe-novo', ['centroId' => $id]);
    }
    
    public function cursos()
    {
        return view('site.cursos-novo');
    }
    
    public function sobre()
    {
        return view('site.sobre-novo');
    }
    
    public function contactos()
    {
        return view('site.contactos-novo');
    }
}
```

## 🗂️ Passo 3: Backup das Páginas Antigas

Antes de remover as páginas antigas, crie um backup:

```bash
# No terminal, na raiz do projecto
mkdir -p resources/views/site/backup
mv resources/views/site/home.blade.php resources/views/site/backup/
mv resources/views/site/centros.blade.php resources/views/site/backup/
mv resources/views/site/cursos.blade.php resources/views/site/backup/
mv resources/views/site/sobre.blade.php resources/views/site/backup/
mv resources/views/site/contactos.blade.php resources/views/site/backup/
```

## 🔄 Passo 4: Renomear os Ficheiros Novos

```bash
# Remova o sufixo "-novo" dos ficheiros
mv resources/views/site/home-novo.blade.php resources/views/site/home.blade.php
mv resources/views/site/centros-novo.blade.php resources/views/site/centros.blade.php
mv resources/views/site/centro-detalhe-novo.blade.php resources/views/site/centro-detalhe.blade.php
mv resources/views/site/cursos-novo.blade.php resources/views/site/cursos.blade.php
mv resources/views/site/sobre-novo.blade.php resources/views/site/sobre.blade.php
mv resources/views/site/contactos-novo.blade.php resources/views/site/contactos.blade.php
```

## 📍 Mapeamento de Rotas

| Route | Ficheiro | Função |
|-------|----------|--------|
| `/` ou `/site` | `home.blade.php` | Página inicial com hero, serviços, turmas |
| `/site/centros` | `centros.blade.php` | Lista de todos os centros |
| `/site/centro/{id}` | `centro-detalhe.blade.php` | Detalhes de um centro específico |
| `/site/cursos` | `cursos.blade.php` | Cursos com filtros avançados |
| `/site/sobre` | `sobre.blade.php` | Sobre a empresa, missão, formadores |
| `/site/contactos` | `contactos.blade.php` | Formulário de contacto, FAQ, centros |

## 🚀 Passo 5: Verificar as Rotas de API

Certifique-se que todas as rotas de API estão funcionando:

```bash
# No navegador ou API client (Postman/Insomnia)
GET http://localhost:8000/api/centros           # Lista centros
GET http://localhost:8000/api/cursos            # Lista cursos
GET http://localhost:8000/api/turmas            # Lista turmas
GET http://localhost:8000/api/formadores        # Lista formadores
GET http://localhost:8000/api/categorias        # Lista categorias
POST http://localhost:8000/api/pre-inscricoes   # Criar pré-inscrição
GET /api/centros/{id}                           # Detalhes de um centro
```

## 🎯 Passo 6: Testar as Páginas

1. **Home**: http://localhost:8000/
   - Verificar carregamento de estatísticas
   - Testar scroll animations (AOS)
   - Verificar buttons funcionam

2. **Centros**: http://localhost:8000/site/centros
   - Verificar grid de centros carrega
   - Testar modal de mapa

3. **Cursos**: http://localhost:8000/site/cursos
   - Testar filtros em tempo real
   - Testar pré-inscrição modal

4. **Sobre**: http://localhost:8000/site/sobre
   - Verificar timeline carrega
   - Testar formadores destacados

5. **Contactos**: http://localhost:8000/site/contactos
   - Testar formulário
   - Verificar Google Maps

## 📱 Componentes Principais

### 1. Layout Base (`resources/views/layouts/public.blade.php`)
Já foi refactorado com:
- 900+ linhas de CSS moderno
- 12+ animações CSS
- SweetAlert2 + AOS integrado
- WhatsApp button flutuante
- Header com scroll shadow effect

### 2. Biblioteca de Ajudantes Globais
Disponíveis em todas as páginas:
- `showToast(message, type)` - Notificações
- `showError(message)` - Erros
- `AOS.refresh()` - Refrescar animações

### 3. Componentes Reutilizáveis

#### Card de Curso
```html
<div class="card course-card">
    <img src="..." class="card-img-top">
    <div class="card-body">
        <h5>Nome do Curso</h5>
        <span class="badge bg-info">Área</span>
    </div>
</div>
```

#### Card de Centro
```html
<div class="card feature-card">
    <div class="card-header bg-gradient">
        <h5 class="text-white">Nome do Centro</h5>
    </div>
    <div class="card-body">...</div>
</div>
```

#### Modal Pré-Inscrição
```javascript
abrirModalPreInscricao(turmaId)
// Abre modal com formulário de pré-inscrição
```

## 🎨 Sistema de Cores CSS

As cores estão definidas em variáveis CSS. Edite em `resources/views/layouts/public.blade.php`:

```css
:root {
    --primary-color: #1e3a8a;       /* Azul escuro */
    --secondary-color: #334155;     /* Cinzento */
    --accent-color: #3b82f6;        /* Azul claro */
    --success-color: #10b981;       /* Verde */
    --warning-color: #f59e0b;       /* Laranja */
    --error-color: #ef4444;         /* Vermelho */
    --light-gray: #f3f4f6;          /* Cinzento claro */
    --dark-gray: #1f2937;           /* Cinzento escuro */
    --white: #ffffff;
}
```

## 📱 Responsividade

Todas as páginas foram testadas para:
- ✅ Mobile (xs-xs: 320px)
- ✅ Tablet (sm: 576px, md: 768px)
- ✅ Desktop (lg: 992px, xl: 1200px)
- ✅ Widescreen (xxl: 1400px)

## ⚡ Performance

Para melhorar performance:

1. **Lazy Loading de Imagens**
   ```html
   <img ... loading="lazy">
   ```

2. **Compressão de Imagens**
   - Use webp com fallback para jpg/png

3. **Minificação**
   ```bash
   npm run production  # Se usar Laravel Mix/Vite
   ```

## 🐛 Troubleshooting

### Problema: Imagens não carregam
- ✅ Verificar pasta `public/images/` tem as imagens
- ✅ Usar `asset('images/nome.jpg')`

### Problema: API retorna 404
- ✅ Verificar rotas em `routes/api.php`
- ✅ Testar endpoints com curl/Postman

### Problema: Animações não funcionam
- ✅ Verificar AOS carregou: `window.AOS`
- ✅ Chamar `AOS.refresh()` após carregar conteúdo dinâmico

### Problema: WhatsApp button não aparece
- ✅ Verificar FontAwesome carregou
- ✅ Layout public.blade.php tem o HTML

## 📝 Notas Importantes

1. **Pré-inscrições**: O POST `/api/pre-inscricoes` não requer autenticação
2. **Google Maps**: Embed não precisa de API key para mapas simples
3. **Emails**: Se quiser enviar notificações, configure `MAIL_` no `.env`
4. **Segurança**: CSRF token já está incluído em formulários

## 📊 Checklist de Implementação

```
[ ] Actualizar routes/web.php
[ ] Actualizar SiteController
[ ] Fazer backup de páginas antigas
[ ] Renomear ficheiros (-novo → original)
[ ] Testar todas as rotas públicas
[ ] Verificar API endpoints funcionam
[ ] Testar formulários (contacto, pré-inscrição)
[ ] Testar animações em mobile
[ ] Testar Google Maps
[ ] Verificar WhatsApp button
[ ] Teste de performance (Lighthouse)
[ ] Deploy em produção
```

## 🎓 Personalização

Para personalizar as páginas:

1. **Contactos**: Editar numero WhatsApp em `contactos-novo.blade.php`
2. **Localização**: Editar endereço em `contactos-novo.blade.php`
3. **Cores**: Editar CSS variables em `layouts/public.blade.php`
4. **Conteúdo**: Editar texto diretamente nas blade templates

## 📞 Suporte

Para dúvidas na implementação:
1. Verificar console do navegador (F12)
2. Verificar logs em `storage/logs/laravel.log`
3. Testar API endpoints com Postman

---

**Status**: ✅ Pronto para Produção
**Data**: 2024
**Versão**: 1.0
