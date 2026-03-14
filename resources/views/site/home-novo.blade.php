@extends('layouts.public')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6 hero-content">
                <h1 class="hero-title">Invista no seu <span class="text-gradient">Futuro Profissional</span></h1>
                <p class="hero-subtitle">
                    Formação de qualidade com mais de 10 anos de experiência. Prepare-se para os desafios do mercado de trabalho com os nossos cursos especializados.
                </p>
                <div class="hero-cta">
                    <a href="{{ route('site.cursos') }}" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Explorar Cursos
                    </a>
                    <a href="#sobre-nós" class="btn btn-outline-light">
                        <i class="fas fa-info-circle me-2"></i>Saber Mais
                    </a>
                </div>
            </div>
            <div class="col-lg-6 hero-image" data-aos="fade-in">
                <img src="{{ asset('images/banner-11.jpg') }}" alt="Formação Profissional" class="img-fluid rounded-3">
            </div>
        </div>
    </div>
</section>

<!-- Estatísticas Section -->
<section class="section" id="estatisticas">
    <div class="container">
        <h2 class="section-title">Nossas Conquistas</h2>
        <p class="section-subtitle">Números que demonstram nosso compromisso com a excelência</p>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up">
                <div class="card feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="counter text-gradient">500+</h3>
                    <p class="text-muted">Alunos Formados</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3 class="counter text-gradient" id="total-cursos-home">-</h3>
                    <p class="text-muted">Cursos Disponíveis</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 class="counter text-gradient" id="total-centros-home">-</h3>
                    <p class="text-muted">Centros de Formação</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3 class="counter text-gradient">100%</h3>
                    <p class="text-muted">Taxa de Sucesso</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Nossos Centros Section -->
<section class="section" id="centros">
    <div class="container">
        <h2 class="section-title">Centros de Formação</h2>
        <p class="section-subtitle">Escolha o centro mais próximo de si</p>
        
        <div class="row g-4" id="centros-home">
            <div class="col-12">
                <div class="loading">
                    <div class="spinner"></div>
                    <p>Carregando centros...</p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('site.centros') }}" class="btn btn-primary">
                <i class="fas fa-eye me-2"></i>Ver Todos os Centros
            </a>
        </div>
    </div>
</section>

<!-- Serviços Section -->
<section class="section" id="servicos">
    <div class="container">
        <h2 class="section-title">Nossos Serviços</h2>
        <p class="section-subtitle">Soluções completas para o seu sucesso académico e profissional</p>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="card service-card">
                    <div class="card-img-container">
                        <img src="{{ asset('images/banner-2.jpg') }}" alt="Projectos Académicos" class="service-img">
                        <div class="card-overlay">
                            <div class="feature-icon">
                                <i class="fas fa-book"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Projectos Académicos</h5>
                        <p class="card-text text-muted small">
                            Apoio especializado para monografias, dissertações e teses.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card service-card">
                    <div class="card-img-container">
                        <img src="{{ asset('images/banner-3.jpg') }}" alt="Formação Profissional" class="service-img">
                        <div class="card-overlay">
                            <div class="feature-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Formação Profissional</h5>
                        <p class="card-text text-muted small">
                            Cursos certificados em diversas áreas do conhecimento.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card service-card">
                    <div class="card-img-container">
                        <img src="{{ asset('images/banner-4.jpg') }}" alt="Workshops" class="service-img">
                        <div class="card-overlay">
                            <div class="feature-icon">
                                <i class="fas fa-chalkboard"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Workshops e Seminários</h5>
                        <p class="card-text text-muted small">
                            Sessões práticas e interactivas com especialistas.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card service-card">
                    <div class="card-img-container">
                        <img src="{{ asset('images/banner-5.jpg') }}" alt="Consultoria" class="service-img">
                        <div class="card-overlay">
                            <div class="feature-icon">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Consultoria Educacional</h5>
                        <p class="card-text text-muted small">
                            Orientação personalizada para seu percurso académico.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="card service-card">
                    <div class="card-img-container">
                        <img src="{{ asset('images/banner-9.jpg') }}" alt="Certificações" class="service-img">
                        <div class="card-overlay">
                            <div class="feature-icon">
                                <i class="fas fa-award"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Certificações Profissionais</h5>
                        <p class="card-text text-muted small">
                            Diplomas reconhecidos internacionalmente no mercado.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="card service-card">
                    <div class="card-img-container">
                        <img src="{{ asset('images/banner-10.jpg') }}" alt="Suporte" class="service-img">
                        <div class="card-overlay">
                            <div class="feature-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Suporte Personalizado</h5>
                        <p class="card-text text-muted small">
                            Acompanhamento durante todo o seu percurso formativo.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Turmas/Cursos Disponíveis Section -->
<section class="section" id="cursos">
    <div class="container">
        <h2 class="section-title">Turmas Disponíveis</h2>
        <p class="section-subtitle">Inscreva-se agora e comece sua transformação</p>
        
        <div id="turmas-home">
            <div class="loading">
                <div class="spinner"></div>
                <p>Carregando turmas...</p>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('site.cursos') }}" class="btn btn-primary">
                <i class="fas fa-search me-2"></i>Ver Todas as Turmas
            </a>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="section bg-gradient" style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="text-white mb-3">Fique Atualizado</h2>
                <p class="text-white-50 mb-0">Subscreva a nossa newsletter e receba as últimas novidades sobre cursos e promoções.</p>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <form class="d-flex gap-2">
                    <input type="email" class="form-control" placeholder="Seu email..." required>
                    <button type="submit" class="btn btn-light fw-bold">
                        <i class="fas fa-paper-plane me-2"></i>Subscrever
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- CTA Final Section -->
<section class="section" id="sobre-nós">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="section-title mb-3">Por que escolher MC-COMERCIAL?</h2>
                <div class="list-group list-group-flush">
                    <div class="list-group-item border-0 ps-0 py-3" data-aos="fade-up">
                        <h5 class="mb-1">
                            <i class="fas fa-check-circle text-success me-2"></i>Experiência Comprovada
                        </h5>
                        <p class="text-muted mb-0">Mais de 10 anos formando profissionais qualificados</p>
                    </div>
                    <div class="list-group-item border-0 ps-0 py-3" data-aos="fade-up" data-aos-delay="100">
                        <h5 class="mb-1">
                            <i class="fas fa-check-circle text-success me-2"></i>Cursos Especializados
                        </h5>
                        <p class="text-muted mb-0">Programas actualizados alinhados com o mercado</p>
                    </div>
                    <div class="list-group-item border-0 ps-0 py-3" data-aos="fade-up" data-aos-delay="200">
                        <h5 class="mb-1">
                            <i class="fas fa-check-circle text-success me-2"></i>Formadores Experientes
                        </h5>
                        <p class="text-muted mb-0">Profissionais com vasta experiência nas áreas</p>
                    </div>
                    <div class="list-group-item border-0 ps-0 py-3" data-aos="fade-up" data-aos-delay="300">
                        <h5 class="mb-1">
                            <i class="fas fa-check-circle text-success me-2"></i>Certificações Reconhecidas
                        </h5>
                        <p class="text-muted mb-0">Diplomas válidos e reconhecidos no mercado</p>
                    </div>
                </div>
                
                <a href="{{ route('site.sobre') }}" class="btn btn-primary mt-4">
                    <i class="fas fa-arrow-right me-2"></i>Saber Mais Sobre Nós
                </a>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="ratio ratio-16x9">
                    <iframe src="https://maps.google.com/maps?q=Luanda+Viana&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                            style="border:0; border-radius: 1rem;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <p class="text-center text-muted mt-3 small">
                    <i class="fas fa-map-marker-alt me-1"></i>
                    Rua A, Bairro 1º de Maio, Luanda-Viana
                </p>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    // Carregar estatísticas
    async function carregarEstatisticas() {
        try {
            const headers = {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            };
            const cursos = await fetch('/cursos', { headers }).then(r => r.json());
            const centros = await fetch('/centros', { headers }).then(r => r.json());
            
            document.getElementById('total-cursos-home').textContent = cursos.length || 0;
            document.getElementById('total-centros-home').textContent = centros.length || 0;
        } catch (error) {
            console.error('Erro ao carregar estatísticas:', error);
        }
    }
    
    // Carregar centros
    async function carregarCentros() {
        try {
            const response = await fetch('/centros', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const centros = await response.json();
            
            const container = document.getElementById('centros-home');
            
            if (centros.length === 0) {
                container.innerHTML = '<div class="col-12 text-center text-muted"><p>Nenhum centro disponível</p></div>';
                return;
            }
            
            let html = '';
            centros.forEach((centro, index) => {
                html += `
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="${index * 100}">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <div class="feature-icon mb-3">
                                    <i class="fas fa-building"></i>
                                </div>
                                <h5 class="card-title">${centro.nome}</h5>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-map-marker-alt me-1"></i>${centro.localizacao || 'Localização disponível'}
                                </p>
                                <p class="text-muted small mb-3">
                                    <i class="fas fa-phone me-1"></i>
                                    <a href="tel:${centro.contactos?.[0]}" class="text-decoration-none">
                                        ${centro.contactos?.[0] || 'Contacto disponível'}
                                    </a>
                                </p>
                                <a href="/site/centro/${centro.id}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-right me-1"></i>Explorar
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
            AOS.refresh();
        } catch (error) {
            console.error('Erro ao carregar centros:', error);
            document.getElementById('centros-home').innerHTML = '<div class="col-12 text-center text-danger"><p>Erro ao carregar centros</p></div>';
        }
    }
    
    // Carregar turmas
    async function carregarTurmas() {
        try {
            const response = await fetch('/turmas?per_page=6&publicado=true', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();
            const turmas = data.data || data;
            
            const container = document.getElementById('turmas-home');
            
            if (turmas.length === 0) {
                container.innerHTML = '<div class="col-12 text-center text-muted"><p>Nenhuma turma disponível</p></div>';
                return;
            }
            
            let html = '<div class="row g-4">';
            turmas.forEach((turma, index) => {
                const vagas = turma.vagas_totais ? (turma.vagas_totais - (turma.vagas_preenchidas || 0)) : '—';
                html += `
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="${index * 100}">
                        <div class="card h-100">
                            <img src="${turma.curso?.imagem_url || '/images/banner-11.jpg'}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">${turma.curso?.nome || 'Curso'}</h5>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-sun me-1"></i>${turma.periodo?.charAt(0).toUpperCase() + turma.periodo?.slice(1) || 'Período'}
                                </p>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-calendar me-1"></i>Início: ${new Date(turma.data_arranque).toLocaleDateString('pt-PT')}
                                </p>
                                <p class="text-muted small mb-3">
                                    <i class="fas fa-users me-1"></i>Vagas: <span class="badge bg-info">${vagas}</span>
                                </p>
                                <button class="btn btn-sm btn-primary w-100" onclick="abrirModalPreInscricao(${turma.id})">
                                    <i class="fas fa-edit me-1"></i>Pré-inscrever-se
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            
            container.innerHTML = html;
            AOS.refresh();
        } catch (error) {
            console.error('Erro ao carregar turmas:', error);
            document.getElementById('turmas-home').innerHTML = '<div class="col-12 text-center text-danger"><p>Erro ao carregar turmas</p></div>';
        }
    }
    
    // Modal pré-inscrição
    function abrirModalPreInscricao(turmaId) {
        Swal.fire({
            title: 'Pré-Inscrição',
            html: `
                <form id="formPreInscricao" class="text-start">
                    <div class="mb-3">
                        <label class="form-label">Nome Completo *</label>
                        <input type="text" class="form-control" id="nomeCompleto" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" id="emailPreIns" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telefone (Opcional)</label>
                        <input type="tel" class="form-control" id="telefonePadrão" placeholder="+244 9...">
                    </div>
                    <div class="mb-3">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" id="concordo" required>
                            Concordo com os termos e condições
                        </label>
                    </div>
                </form>
            `,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Inscrever-se',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                const nome = document.getElementById('nomeCompleto').value;
                const email = document.getElementById('emailPreIns').value;
                const telefone = document.getElementById('telefonePadrão').value;
                const concordo = document.getElementById('concordo').checked;
                
                if (!nome || !email || !concordo) {
                    Swal.showValidationMessage('Preencha todos os campos obrigatórios');
                    return false;
                }
                
                return { nome, email, telefone };
            }
        }).then(result => {
            if (result.isConfirmed && result.value) {
                enviarPreInscricao(turmaId, result.value);
            }
        });
    }
    
    // Enviar pré-inscrição
    async function enviarPreInscricao(turmaId, dados) {
        try {
            const response = await fetch('/api/pre-inscricoes', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    turma_id: turmaId,
                    nome_completo: dados.nome,
                    email: dados.email,
                    contactos: dados.telefone ? [dados.telefone] : [],
                    status: 'pendente'
                })
            });
            
            if (response.ok) {
                showToast('Pré-inscrição realizada com sucesso!');
            } else {
                showError('Erro ao realizar pré-inscrição');
            }
        } catch (error) {
            console.error('Erro:', error);
            showError('Erro ao processar pré-inscrição');
        }
    }
    
    // Executar ao carregar a página
    document.addEventListener('DOMContentLoaded', () => {
        carregarEstatisticas();
        carregarCentros();
        carregarTurmas();
    });
</script>
@endsection
