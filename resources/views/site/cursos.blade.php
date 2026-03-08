@extends('layouts.public')

@section('title', 'Cursos Disponíveis')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">
                    Cursos de Formação Profissional
                </h1>
                <p class="lead mb-4 text-muted">
                    Explore nossa ampla gama de cursos projetados para impulsionar sua carreira. 
                    De tecnologia a gestão, temos o conhecimento que você precisa para ter sucesso.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#cursos-lista" class="btn btn-primary btn-lg">
                        <i class="fas fa-search me-2"></i>Explorar Cursos
                    </a>
                    <a href="{{ route('site.contactos') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-phone me-2"></i>Falar Connosco
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="/images/banner-11.jpg" alt="Formação Profissional" class="img-fluid rounded-3 shadow-lg" style="max-height: 400px; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<!-- Filtros de Cursos -->
<section class="section bg-light" id="cursos-lista">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="section-title">Nossos Cursos</h2>
                <p class="text-muted mb-4">Escolha o curso ideal para seu desenvolvimento profissional</p>
            </div>
        </div>

        <!-- Filtros -->
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label for="filtro-area" class="form-label">Área de Formação</label>
                                <select class="form-select" id="filtro-area">
                                    <option value="">Todas as áreas</option>
                                    <option value="Informática">Informática</option>
                                    <option value="Gestão">Gestão</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Recursos Humanos">Recursos Humanos</option>
                                    <option value="Contabilidade">Contabilidade</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label for="filtro-modalidade" class="form-label">Modalidade</label>
                                <select class="form-select" id="filtro-modalidade">
                                    <option value="">Todas as modalidades</option>
                                    <option value="presencial">Presencial</option>
                                    <option value="online">Online</option>
                                    <option value="hibrido">Híbrido</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="filtro-centro" class="form-label">Centro</label>
                                <select class="form-select" id="filtro-centro">
                                    <option value="">Todos os centros</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Cursos -->
        <div class="row" id="cursos-grid">
            <div class="col-12 text-center py-5">
                <i class="fas fa-spinner fa-spin fa-3x text-primary mb-3"></i>
                <p class="text-muted">Carregando cursos disponíveis...</p>
            </div>
        </div>

        <!-- Pagination -->
        <div class="row mt-4">
            <div class="col-12">
                <nav aria-label="Navegação de páginas" id="pagination-nav" style="display: none;">
                    <ul class="pagination justify-content-center" id="pagination-list">
                        <!-- Pagination será inserida aqui via JavaScript -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h3 class="mb-4">Não encontra o que procura?</h3>
                <p class="text-muted mb-4">
                    Entre em contacto connosco! A nossa equipa está disponível para esclarecer 
                    todas as suas dúvidas e ajudá-lo a encontrar o curso ideal para os seus objetivos.
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="{{ route('site.contactos') }}" class="btn btn-primary">
                        <i class="fas fa-phone me-2"></i>Contactar-nos
                    </a>
                    <a href="mailto:mucuanha.chineva@gmail.com" class="btn btn-outline-primary">
                        <i class="fas fa-envelope me-2"></i>Enviar Email
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    carregarCursos();
    carregarCentros();
    
    // Event listeners para filtros
    $('#filtro-area, #filtro-modalidade, #filtro-centro').on('change', function() {
        carregarCursos();
    });
});

/**
 * Carrega a lista de cursos da API
 */
function carregarCursos() {
    const area = $('#filtro-area').val();
    const modalidade = $('#filtro-modalidade').val();
    const centro = $('#filtro-centro').val();
    
    let url = '/api/cursos';
    let params = [];
    
    if (area) params.push(`area=${encodeURIComponent(area)}`);
    if (modalidade) params.push(`modalidade=${encodeURIComponent(modalidade)}`);
    if (centro) params.push(`centro_id=${encodeURIComponent(centro)}`);
    
    if (params.length > 0) {
        url += '?' + params.join('&');
    }
    
    $.get(url, function(data) {
        exibirCursos(data);
    }).fail(function() {
        $('#cursos-grid').html(`
            <div class="col-12 text-center py-5">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <h5>Erro ao carregar cursos</h5>
                <p class="text-muted">Tente novamente mais tarde ou contacte-nos para assistência.</p>
                <a href="{{ route('site.contactos') }}" class="btn btn-primary">
                    <i class="fas fa-phone me-2"></i>Contactar Suporte
                </a>
            </div>
        `);
    });
}

/**
 * Carrega a lista de centros para o filtro
 */
function carregarCentros() {
    $.get('/api/centros', function(data) {
        let options = '<option value="">Todos os centros</option>';
        data.forEach(function(centro) {
            options += `<option value="${centro.id}">${centro.nome}</option>`;
        });
        $('#filtro-centro').html(options);
    }).fail(function() {
        console.error('Erro ao carregar centros para filtro');
    });
}

/**
 * Exibe os cursos na interface
 * @param {Array} cursos - Lista de cursos
 */
function exibirCursos(cursos) {
    let html = '';
    
    if (cursos.length === 0) {
        html = `
            <div class="col-12 text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h5>Nenhum curso encontrado</h5>
                <p class="text-muted">Tente ajustar os filtros ou contacte-nos para mais informações.</p>
                <a href="{{ route('site.contactos') }}" class="btn btn-primary">
                    <i class="fas fa-phone me-2"></i>Falar Connosco
                </a>
            </div>
        `;
    } else {
        cursos.forEach(function(curso) {
            const modalidadeBadge = getModalidadeBadge(curso.modalidade);
            
            // Gerar badges dos centros (pode ser múltiplos)
            let centrosBadges = '';
            if (curso.centros && curso.centros.length > 0) {
                centrosBadges = curso.centros.map(centro => 
                    `<span class="badge bg-secondary me-1 mb-1">${centro.nome}</span>`
                ).join('');
            }
            
            // Buscar duração e preço dos centros (pegar o primeiro centro como referência)
            let duracao = 'A definir';
            let preco = null;
            if (curso.centros && curso.centros.length > 0 && curso.centros[0].pivot) {
                duracao = curso.centros[0].pivot.duracao || 'A definir';
                preco = curso.centros[0].pivot.preco;
            }
            
            html += `
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm curso-card">
                        <div class="card-img-container position-relative">
                            <img src="${getCursoImage(curso.area)}" 
                                 alt="${curso.nome}" 
                                 class="card-img-top" 
                                 style="height: 200px; object-fit: cover;">
                            <div class="card-overlay">
                                <div class="badges">
                                    ${modalidadeBadge}
                                    ${centrosBadges}
                                </div>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="mb-auto">
                                <h5 class="card-title">${curso.nome}</h5>
                                <p class="card-text text-muted mb-2">
                                    <i class="fas fa-tag me-1"></i>${curso.area}
                                </p>
                                <p class="card-text small">${curso.descricao || 'Descrição não disponível'}</p>
                                ${centrosBadges ? `<div class="mb-2">${centrosBadges}</div>` : ''}
                            </div>
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        ${duracao}
                                    </small>
                                    ${preco ? `<small class="text-success fw-bold">${preco}Kz</small>` : 
                                        '<small class="text-muted">Consultar preço</small>'}
                                </div>
                                <div class="d-grid">
                                    <a href="/pre-inscricao?curso_id=${curso.id}" class="btn btn-primary">
                                        <i class="fas fa-user-plus me-2"></i>Inscrever-me
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
    }
    
    $('#cursos-grid').html(html);
}

/**
 * Retorna a badge adequada para a modalidade
 * @param {string} modalidade - A modalidade do curso
 * @returns {string} - HTML da badge
 */
function getModalidadeBadge(modalidade) {
    const badges = {
        'presencial': '<span class="badge bg-success">Presencial</span>',
        'online': '<span class="badge bg-info">Online</span>',
        'hibrido': '<span class="badge bg-warning text-dark">Híbrido</span>'
    };
    return badges[modalidade] || '<span class="badge bg-secondary">Não definido</span>';
}

/**
 * Retorna uma imagem adequada baseada na área do curso
 * @param {string} area - A área do curso
 * @returns {string} - URL da imagem
 */
function getCursoImage(area) {
    const images = {
        'Gestão': '/images/banner-10.jpg',
        'Contabilidade': '/images/banner-10.jpg',
        'Informática': '/images/banner-10.jpg',
        'Inglês': '/images/banner-10.jpg',
        'Matemática': '/images/banner-10.jpg',
        'Programação': '/images/banner-10.jpg'
    };
    
    return images[area] || '/images/banner-10.jpg';
}
</script>

<style>
.curso-card {
    transition: all 0.3s ease;
    border: none;
}

.curso-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.card-img-container {
    overflow: hidden;
}

.card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.3);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: flex-start;
    justify-content: flex-end;
    padding: 1rem;
}

.curso-card:hover .card-overlay {
    opacity: 1;
}

.badges {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.min-vh-50 {
    min-height: 50vh;
}
</style>
@endsection
