@extends('layouts.public')

@section('title', 'Sobre MC-COMERCIAL')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 class="page-title">Sobre MC-COMERCIAL</h1>
        <p class="page-subtitle">Conheça nossa história e missão</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Sobre</li>
            </ol>
        </nav>
    </div>
</section>

<!-- História Section -->
<section class="section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="{{ asset('images/banner-11.jpg') }}" alt="Nossa História" class="img-fluid rounded-3">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <h2 class="section-title mb-3">Nossa História</h2>
                <p class="text-muted mb-3">
                    Fundada em 2013, a MC-COMERCIAL nasceu de uma visão clara: oferecer formação profissional de qualidade 
                    que preparasse os nossos alunos para os desafios reais do mercado de trabalho.
                </p>
                <p class="text-muted mb-3">
                    Durante estes 10 anos, desenvolvemos uma reputação sólida por excelência académica, formadores 
                    experientes e programas inovadores que combinam teoria com prática.
                </p>
                <p class="text-muted mb-4">
                    Hoje, somos orgulhosos de ter formado mais de 500 profissionais que se destacam em diversas áreas 
                    do mercado, contribuindo significativamente para o desenvolvimento de Angola.
                </p>
                <div class="d-flex gap-2">
                    <div class="feature-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <div>
                        <h6>Excelência em Formação</h6>
                        <p class="text-muted small mb-0">Certificação e reconhecimento no mercado</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Missão, Visão e Valores -->
<section class="section bg-light">
    <div class="container">
        <h2 class="section-title mb-4 text-center">Missão, Visão e Valores</h2>
        
        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-up">
                <div class="card h-100 feature-card border-0">
                    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color)); border-radius: 1rem 1rem 0 0;">
                        <h5 class="text-white mb-0">
                            <i class="fas fa-bullseye me-2"></i>Missão
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">
                            Providenciar formação profissional de qualidade que capacite os nossos alunos a terem sucesso 
                            numa economia em constante mudança.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 feature-card border-0">
                    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, var(--accent-color), var(--secondary-color)); border-radius: 1rem 1rem 0 0;">
                        <h5 class="text-white mb-0">
                            <i class="fas fa-telescope me-2"></i>Visão
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">
                            Ser a instituição de referência em formação profissional em Angola, reconhecida pela qualidade 
                            dos programas e sucesso dos nossos alunos.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 feature-card border-0">
                    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, var(--secondary-color), var(--primary-color)); border-radius: 1rem 1rem 0 0;">
                        <h5 class="text-white mb-0">
                            <i class="fas fa-heart me-2"></i>Valores
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i><strong>Excelência</strong></li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i><strong>Integridade</strong></li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i><strong>Inovação</strong></li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i><strong>Compromisso</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Equipa Principais -->
<section class="section">
    <div class="container">
        <h2 class="section-title mb-4 text-center">Formadores Destacados</h2>
        
        <div class="row g-4" id="formadores-grid">
            <div class="col-12">
                <div class="loading">
                    <div class="spinner"></div>
                    <p>Carregando formadores...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Timeline de Marcos -->
<section class="section bg-light">
    <div class="container">
        <h2 class="section-title mb-4 text-center">Marcos Importantes</h2>
        
        <div class="timeline">
            <div class="timeline-item" data-aos="fade-up">
                <div class="timeline-marker">
                    <i class="fas fa-star"></i>
                </div>
                <div class="timeline-content">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Fundação</h5>
                        <span class="badge bg-primary">2013</span>
                    </div>
                    <p class="text-muted mb-0">Nascimento da MC-COMERCIAL com foco em qualidade formativa</p>
                </div>
            </div>
            
            <div class="timeline-item" data-aos="fade-up" data-aos-delay="100">
                <div class="timeline-marker">
                    <i class="fas fa-star"></i>
                </div>
                <div class="timeline-content">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Expansão</h5>
                        <span class="badge bg-primary">2015</span>
                    </div>
                    <p class="text-muted mb-0">Abertura do segundo centro de formação em Luanda-Viana</p>
                </div>
            </div>
            
            <div class="timeline-item" data-aos="fade-up" data-aos-delay="200">
                <div class="timeline-marker">
                    <i class="fas fa-star"></i>
                </div>
                <div class="timeline-content">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Marco de 300 Alunos</h5>
                        <span class="badge bg-primary">2018</span>
                    </div>
                    <p class="text-muted mb-0">Atingimos a marca de 300 alunos formados com sucesso</p>
                </div>
            </div>
            
            <div class="timeline-item" data-aos="fade-up" data-aos-delay="300">
                <div class="timeline-marker">
                    <i class="fas fa-star"></i>
                </div>
                <div class="timeline-content">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Era Digital</h5>
                        <span class="badge bg-primary">2021</span>
                    </div>
                    <p class="text-muted mb-0">Lançamento de plataforma online para formação remota</p>
                </div>
            </div>
            
            <div class="timeline-item" data-aos="fade-up" data-aos-delay="400">
                <div class="timeline-marker">
                    <i class="fas fa-star"></i>
                </div>
                <div class="timeline-content">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Presente</h5>
                        <span class="badge bg-primary">2024</span>
                    </div>
                    <p class="text-muted mb-0">500+ alunos formados e reconhecimento no mercado profissional</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testemunhos Section -->
<section class="section">
    <div class="container">
        <h2 class="section-title mb-4 text-center">O que Dizem Nossos Alunos</h2>
        
        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-up">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text mb-3 fst-italic">
                            "O curso foi excelente, os formadores são muito experientes e o acompanhamento personalizado 
                            foi decisivo para o meu sucesso profissional."
                        </p>
                        <h6 class="mb-1">João Silva</h6>
                        <p class="text-muted small">Curso de Marketing Digital</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text mb-3 fst-italic">
                            "Recomendo a MC-COMERCIAL a qualquer um que queira investir no seu desenvolvimento profissional. 
                            Vale muito a pena!"
                        </p>
                        <h6 class="mb-1">Maria Costa</h6>
                        <p class="text-muted small">Curso de Gestão de Projetos</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text mb-3 fst-italic">
                            "Consegui emprego 2 meses após terminar o curso. A qualidade da formação abriu-me muitas portas 
                            no mercado de trabalho."
                        </p>
                        <h6 class="mb-1">Pedro Nkondo</h6>
                        <p class="text-muted small">Curso de Programação Web</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section" style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
    <div class="container text-center text-white" data-aos="zoom-in">
        <h2 class="mb-3">Pronto para Começar?</h2>
        <p class="mb-4 fs-5">Junte-se a centenas de alunos satisfeitos e transforme seu futuro profissional</p>
        <a href="{{ route('site.cursos') }}" class="btn btn-light btn-lg">
            <i class="fas fa-arrow-right me-2"></i>Explorar Cursos Agora
        </a>
    </div>
</section>

@endsection

@section('scripts')
<script>
    async function carregarFormadores() {
        try {
            const response = await fetch('/formadores?per_page=3', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const formadores = await response.json();
            
            const data = formadores.data || formadores;
            const container = document.getElementById('formadores-grid');
            
            if (data.length === 0) {
                container.innerHTML = '<div class="col-12 text-center text-muted"><p>Nenhum formador disponível</p></div>';
                return;
            }
            
            let html = '';
            data.forEach((formador, index) => {
                html += `
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="${index * 100}">
                        <div class="card h-100 text-center">
                            <img src="${formador.foto_url || '/images/banner-11.jpg'}" class="card-img-top" style="height: 250px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">${formador.nome}</h5>
                                <p class="text-muted mb-3">${formador.especialidade || 'Especialista em Formação'}</p>
                                <div class="d-flex justify-content-center gap-2">
                                    ${formador.contactos?.map((tel, i) => `
                                        <a href="tel:${tel}" class="btn btn-sm btn-outline-primary" title="Contactar">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                    `).join('') || ''}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }
        } catch (error) {
            console.error('Erro ao carregar formadores:', error);
            document.getElementById('formadores-grid').innerHTML = '<div class="col-12 text-center text-danger"><p>Erro ao carregar formadores</p></div>';
        }
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        carregarFormadores();
    });
</script>

<style>
    .timeline {
        position: relative;
        padding: 2rem 0;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, var(--primary-color), var(--accent-color));
        transform: translateX(-50%);
    }
    
    .timeline-item {
        margin-bottom: 3rem;
        position: relative;
    }
    
    .timeline-item:nth-child(odd) .timeline-content {
        margin-left: 0;
        margin-right: 50%;
        padding-right: 3rem;
        text-align: right;
    }
    
    .timeline-item:nth-child(even) .timeline-content {
        margin-left: 50%;
        margin-right: 0;
        padding-left: 3rem;
        text-align: left;
    }
    
    .timeline-marker {
        position: absolute;
        left: 50%;
        top: 0;
        width: 40px;
        height: 40px;
        background: white;
        border: 3px solid var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        transform: translateX(-50%);
        z-index: 10;
    }
    
    @media (max-width: 768px) {
        .timeline::before {
            left: 0;
            transform: translateX(-50%);
        }
        
        .timeline-item:nth-child(odd) .timeline-content,
        .timeline-item:nth-child(even) .timeline-content {
            margin-left: 2.5rem;
            margin-right: 0;
            padding-left: 2rem;
            padding-right: 0;
            text-align: left;
        }
        
        .timeline-marker {
            left: 0;
        }
    }
</style>
@endsection
