@extends('layouts.public')

@section('title', 'Detalhes do Centro')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 class="page-title" id="centro-titulo">Centro de Formação</h1>
        <p class="page-subtitle">Conheça tudo sobre este centro</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('site.centros') }}">Centros</a></li>
                <li class="breadcrumb-item active" id="centro-breadcrumb">Centro</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Centro Info Section -->
<section class="section">
    <div class="container">
        <div class="row g-5 align-items-start">
            <!-- Informações -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="card border-0 shadow-lg mb-4">
                    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
                        <h5 class="text-white mb-0">
                            <i class="fas fa-info-circle me-2"></i>Informações de Contacto
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="info-item mb-4">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>Localização
                            </h6>
                            <p id="centro-localizacao" class="mb-0">Carregando...</p>
                        </div>
                        
                        <div class="info-item mb-4">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-phone me-2 text-primary"></i>Telefone
                            </h6>
                            <div id="centro-telefone">Carregando...</div>
                        </div>
                        
                        <div class="info-item">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-envelope me-2 text-primary"></i>Email
                            </h6>
                            <p id="centro-email" class="mb-0">Carregando...</p>
                        </div>
                    </div>
                </div>
                
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, var(--accent-color), var(--secondary-color));">
                        <h5 class="text-white mb-0">
                            <i class="fas fa-stats me-2"></i>Estatísticas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="stat-item mb-3">
                            <h6 class="text-muted mb-1">Cursos Disponíveis</h6>
                            <h3 class="text-gradient mb-0" id="centro-total-cursos">0</h3>
                        </div>
                        
                        <div class="stat-item mb-3">
                            <h6 class="text-muted mb-1">Turmas em Andamento</h6>
                            <h3 class="text-gradient mb-0" id="centro-total-turmas">0</h3>
                        </div>
                        
                        <div class="stat-item">
                            <h6 class="text-muted mb-1">Formadores</h6>
                            <h3 class="text-gradient mb-0" id="centro-total-formadores">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Mapa -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="card border-0 overflow-hidden" style="height: 400px;">
                    <div class="ratio ratio-16x9">
                        <iframe id="centro-mapa" src="" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
                
                <div class="card mt-3 border-0">
                    <div class="card-body">
                        <h6 class="mb-3">
                            <i class="fas fa-share-alt text-primary me-2"></i>Partilhar
                        </h6>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-sm btn-outline-primary" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-primary" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-primary" title="WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-primary" title="Email">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cursos Disponíveis -->
<section class="section bg-light">
    <div class="container">
        <h2 class="section-title mb-4 text-center">Cursos Disponíveis Neste Centro</h2>
        
        <div class="row g-4" id="centro-cursos">
            <div class="col-12">
                <div class="loading">
                    <div class="spinner"></div>
                    <p>Carregando cursos...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Turmas Disponíveis -->
<section class="section">
    <div class="container">
        <h2 class="section-title mb-4 text-center">Turmas em Execução</h2>
        
        <div class="row g-4" id="centro-turmas">
            <div class="col-12">
                <div class="loading">
                    <div class="spinner"></div>
                    <p>Carregando turmas...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Formadores -->
<section class="section bg-light">
    <div class="container">
        <h2 class="section-title mb-4 text-center">Formadores do Centro</h2>
        
        <div class="row g-4" id="centro-formadores">
            <div class="col-12">
                <div class="loading">
                    <div class="spinner"></div>
                    <p>Carregando formadores...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section" style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
    <div class="container text-center text-white" data-aos="zoom-in">
        <h2 class="mb-3">Pronto para Começar?</h2>
        <p class="mb-4 fs-5">Inscreva-se num dos cursos disponíveis neste centro</p>
        <a href="{{ route('site.cursos') }}" class="btn btn-light btn-lg">
            <i class="fas fa-arrow-right me-2"></i>Ver Todos os Cursos
        </a>
    </div>
</section>

@endsection

@section('scripts')
<script>
    const centroId = {{ $centroId ?? 0 }};
    let centroDados = null;
    
    // Carregar dados do centro
    async function carregarCentro() {
        try {
            const response = await fetch(`/api/centros/${centroId}`);
            const centro = await response.json();
            
            centroDados = centro;
            
            // Actualizar header
            document.getElementById('centro-titulo').textContent = centro.nome;
            document.getElementById('centro-breadcrumb').textContent = centro.nome;
            
            // Actualizar informações
            document.getElementById('centro-localizacao').textContent = centro.localizacao || 'Localização disponível';
            
            const telefonesHtml = (centro.contactos || [])
                .map(tel => `<a href="tel:${tel}" class="d-block text-decoration-none">${tel}</a>`)
                .join('') || 'Contacto disponível';
            document.getElementById('centro-telefone').innerHTML = telefonesHtml;
            
            document.getElementById('centro-email').textContent = centro.email || 'Email disponível';
            
            // Mapa
            const mapUrl = `https://maps.google.com/maps?q=${encodeURIComponent(centro.localizacao)}&t=&z=16&ie=UTF8&iwloc=&output=embed`;
            document.getElementById('centro-mapa').src = mapUrl;
            
            // Contar ressources
            carregarCursos();
            carregarTurmas();
            carregarFormadores();
        } catch (error) {
            console.error('Erro ao carregar centro:', error);
            showError('Erro ao carregar dados do centro');
        }
    }
    
    // Carregar cursos
    async function carregarCursos() {
        try {
            const response = await fetch('/api/cursos');
            const cursos = await response.json();
            
            // Filtrar cursos por centro (se tiver associação)
            const cursosFiltrados = cursos.slice(0, 6);
            
            document.getElementById('centro-total-cursos').textContent = cursos.length;
            
            let html = '<div class="row g-4">';
            cursosFiltrados.forEach((curso, index) => {
                html += `
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="${index * 100}">
                        <div class="card h-100">
                            <img src="${curso.imagem_url || '/images/banner-11.jpg'}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title">${curso.nome}</h6>
                                <p class="text-muted small mb-3">${curso.descricao?.substring(0, 80) || 'Descrição'}</p>
                                <span class="badge bg-info me-1">${curso.area || 'Área'}</span>
                                <span class="badge bg-secondary">${curso.modalidade || 'Modalidade'}</span>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            
            document.getElementById('centro-cursos').innerHTML = html;
            AOS.refresh();
        } catch (error) {
            console.error('Erro ao carregar cursos:', error);
        }
    }
    
    // Carregar turmas
    async function carregarTurmas() {
        try {
            const response = await fetch('/api/turmas?publicado=true&per_page=4');
            const data = await response.json();
            const turmas = (data.data || data).slice(0, 4);
            
            document.getElementById('centro-total-turmas').textContent = turmas.length;
            
            let html = '<div class="row g-4">';
            turmas.forEach((turma, index) => {
                const vagas = turma.vagas_totais ? (turma.vagas_totais - (turma.vagas_preenchidas || 0)) : '—';
                html += `
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="${index * 100}">
                        <div class="card h-100 feature-card">
                            <div class="card-header bg-gradient" style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
                                <h6 class="text-white mb-0">${turma.curso?.nome || 'Curso'}</h6>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-sun me-1"></i>
                                    <strong>${turma.periodo?.toUpperCase() || 'PERÍODO'}</strong>
                                </p>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-calendar me-1"></i>
                                    Arranque: ${new Date(turma.data_arranque).toLocaleDateString('pt-PT')}
                                </p>
                                <p class="text-muted small mb-3">
                                    <i class="fas fa-clock me-1"></i>
                                    ${turma.hora_inicio} - ${turma.hora_fim}
                                </p>
                                <button class="btn btn-sm btn-primary w-100" onclick="abrirModalPreInscricao(${turma.id})">
                                    <i class="fas fa-edit me-1"></i>Inscrever-se
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            
            document.getElementById('centro-turmas').innerHTML = html;
            AOS.refresh();
        } catch (error) {
            console.error('Erro ao carregar turmas:', error);
        }
    }
    
    // Carregar formadores
    async function carregarFormadores() {
        try {
            const response = await fetch('/api/formadores');
            const formadores = await response.json();
            
            document.getElementById('centro-total-formadores').textContent = formadores.length;
            
            const formadoresDestacados = formadores.slice(0, 3);
            
            let html = '';
            formadoresDestacados.forEach((formador, index) => {
                html += `
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="${index * 100}">
                        <div class="card h-100 text-center">
                            <img src="${formador.foto_url || '/images/banner-11.jpg'}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title">${formador.nome}</h6>
                                <p class="text-muted small mb-2">${formador.especialidade || 'Especialista'}</p>
                                <div class="d-flex justify-content-center gap-2">
                                    ${formador.contactos?.map(tel => `
                                        <a href="tel:${tel}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                    `).join('') || ''}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            document.getElementById('centro-formadores').innerHTML = `<div class="row g-4">${html}</div>`;
            AOS.refresh();
        } catch (error) {
            console.error('Erro ao carregar formadores:', error);
        }
    }
    
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
    
    async function enviarPreInscricao(turmaId, dados) {
        try {
            const response = await fetch('/api/pre-inscricoes', {
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
    
    document.addEventListener('DOMContentLoaded', () => {
        if (centroId > 0) {
            carregarCentro();
        } else {
            showError('Centro não especificado');
        }
    });
</script>
@endsection
