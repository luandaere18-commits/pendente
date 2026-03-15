@extends('layouts.public')

@section('title', 'Cursos')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 class="page-title">Nossos Cursos</h1>
        <p class="page-subtitle">Explore as opções de formação disponíveis</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Cursos</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Filters and Courses -->
<section class="section">
    <div class="container">
        <div class="row g-4">
            <!-- Filtros -->
            <div class="col-lg-3" data-aos="fade-right">
                <div class="card sticky-top" style="top: 120px;">
                    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
                        <h5 class="text-white mb-0">
                            <i class="fas fa-filter me-2"></i>Filtros
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Busca -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Buscar</label>
                            <input type="text" class="form-control" id="filtro-busca" placeholder="Nome do curso...">
                        </div>
                        
                        <!-- Modalidade -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Modalidade</label>
                            <div class="list-group list-group-flush">
                                <div class="form-check">
                                    <input class="form-check-input filtro-modalidade" type="radio" name="modalidade" 
                                           id="mod-todas" value="" checked>
                                    <label class="form-check-label" for="mod-todas">
                                        Todas
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filtro-modalidade" type="radio" name="modalidade" 
                                           id="mod-presencial" value="presencial">
                                    <label class="form-check-label" for="mod-presencial">
                                        Presencial
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filtro-modalidade" type="radio" name="modalidade" 
                                           id="mod-online" value="online">
                                    <label class="form-check-label" for="mod-online">
                                        Online
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filtro-modalidade" type="radio" name="modalidade" 
                                           id="mod-hibrido" value="híbrido">
                                    <label class="form-check-label" for="mod-hibrido">
                                        Híbrido
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Área -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Área</label>
                            <select class="form-select" id="filtro-area">
                                <option value="">Todas as áreas</option>
                            </select>
                        </div>
                        
                        <!-- Centro -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Centro</label>
                            <select class="form-select" id="filtro-centro">
                                <option value="">Todos os centros</option>
                            </select>
                        </div>
                        
                        <button class="btn btn-outline-secondary w-100" onclick="limparFiltros()">
                            <i class="fas fa-redo me-2"></i>Limpar Filtros
                        </button>
                    </div>
                </div>
            </div>
            
<!-- Cursos Grid -->
            <div class="col-lg-9" data-aos="fade-left">
                <div id="cursos-grid">
                    @if($turmas && $turmas->count() > 0)
                        <div class="row g-4">
                            @php
                                $cursoAgrupado = $turmas->groupBy('curso_id');
                            @endphp
                            
                            @foreach($cursoAgrupado as $cursoId => $turmassDoCurso)
                                @php
                                    $curso = $turmassDoCurso->first()->curso;
                                    $totalVagas = $turmassDoCurso->sum('vagas_totais');
                                    $totalPreenchidas = $turmassDoCurso->sum('vagas_preenchidas');
                                @endphp
                                
                                <div class="col-lg-6" data-aos="fade-up">
                                    <div class="card h-100 course-card">
                                        <div class="position-relative overflow-hidden" style="height: 220px;">
                                            <img src="{{ $curso->imagem_url ?? '/images/banner-11.jpg' }}" class="card-img-top w-100 h-100" 
                                                 style="object-fit: cover;" alt="{{ $curso->nome ?? 'Curso' }}">
                                            <div class="position-absolute top-0 end-0 m-3">
                                                <span class="badge bg-success">
                                                    <i class="fas fa-star me-1"></i>{{ $turmassDoCurso->count() }} Turma{{ $turmassDoCurso->count() !== 1 ? 's' : '' }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $curso->nome ?? 'Curso' }}</h5>
                                            <p class="card-text text-muted small mb-3">{{ Str::limit($curso->descricao ?? 'Descrição do curso', 100) }}</p>
                                            
                                            <div class="course-info mb-3">
                                                <span class="badge bg-light text-dark me-2 mb-2">
                                                    <i class="fas fa-book me-1"></i>{{ $curso->area ?? 'Área' }}
                                                </span>
                                                <span class="badge bg-light text-dark mb-2">
                                                    <i class="fas fa-desktop me-1"></i>{{ $curso->modalidade ?? 'Modalidade' }}
                                                </span>
                                            </div>
                                            
                                            <div class="course-stats mb-3">
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-users me-1"></i>
                                                    Vagas: <strong>{{ max(0, $totalVagas - $totalPreenchidas) }}</strong> de <strong>{{ $totalVagas }}</strong>
                                                </small>
                                                <div class="progress mt-2" style="height: 6px;">
                                                    <div class="progress-bar" role="progressbar" 
                                                         style="width: {{ $totalVagas ? ($totalPreenchidas / $totalVagas * 100) : 0 }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="card-footer bg-white border-top">
                                            <a href="#" class="btn btn-primary btn-sm w-100" 
                                               onclick="mostrarTurmas({{ $cursoId }}, '{{ $curso->nome }}'); return false;">
                                                <i class="fas fa-calendar-alt me-2"></i>Ver Turmas Disponíveis
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="col-12 text-center text-muted">
                            <p>Nenhuma turma publicada no momento.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    let todosCursos = [];
    let todosCentros = [];
    
    // Carregar filtros
    async function carregarFiltros() {
        try {
            const headers = {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            };
            const cursos = await fetch('/cursos', { headers }).then(r => r.json());
            const centros = await fetch('/centros', { headers }).then(r => r.json());
            
            todosCursos = cursos;
            todosCentros = centros;
            
            // Popular áreas únicas
            const areas = [...new Set(cursos.map(c => c.area).filter(Boolean))];
            const selectArea = document.getElementById('filtro-area');
            areas.forEach(area => {
                const option = document.createElement('option');
                option.value = area;
                option.textContent = area;
                selectArea.appendChild(option);
            });
            
            // Popular centros
            const selectCentro = document.getElementById('filtro-centro');
            centros.forEach(centro => {
                const option = document.createElement('option');
                option.value = centro.id;
                option.textContent = centro.nome;
                selectCentro.appendChild(option);
            });
        } catch (error) {
            console.error('Erro ao carregar filtros:', error);
        }
    }
    
    // Aplicar filtros
    async function aplicarFiltros() {
        const busca = document.getElementById('filtro-busca').value.toLowerCase();
        const modalidade = document.querySelector('input[name="modalidade"]:checked').value;
        const area = document.getElementById('filtro-area').value;
        const centroId = document.getElementById('filtro-centro').value;
        
        let curtosFiltrados = todosCursos.filter(curso => {
            const cumpreBusca = !busca || curso.nome.toLowerCase().includes(busca) || 
                                (curso.descricao && curso.descricao.toLowerCase().includes(busca));
            const cumpreArea = !area || curso.area === area;
            
            return cumpreBusca && cumpreArea;
        });
        
        // Carregar turmas e filtrar por modalidade e centro
        try {
            const headers = {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            };
            const turmas = await fetch('/turmas?publicado=true', { headers }).then(r => r.json());
            let turmasArray = turmas.data || turmas;
            
            if (modalidade) {
                turmasArray = turmasArray.filter(t => t.curso?.modalidade === modalidade);
            }
            if (centroId) {
                turmasArray = turmasArray.filter(t => t.curso?.centro_id == centroId);
            }
            
            const cursoIds = [...new Set(turmasArray.map(t => t.curso_id))];
            curtosFiltrados = curtosFiltrados.filter(c => cursoIds.includes(c.id));
            
            exibirCursos(curtosFiltrados, turmasArray);
        } catch (error) {
            console.error('Erro ao aplicar filtros:', error);
        }
    }
    
    function exibirCursos(cursos, turmas) {
        const container = document.getElementById('cursos-grid');
        
        if (cursos.length === 0) {
            container.innerHTML = '<div class="col-12 text-center text-muted"><p>Nenhum curso encontrado</p></div>';
            return;
        }
        
        let html = '<div class="row g-4">';
        
        cursos.forEach((curso, index) => {
            const turmasDocu = turmas.filter(t => t.curso_id === curso.id);
            const totalVagas = turmasDocu.reduce((sum, t) => sum + (t.vagas_totais || 0), 0);
            const totalPreenchidas = turmasDocu.reduce((sum, t) => sum + (t.vagas_preenchidas || 0), 0);
            
            html += `
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="${index * 100}">
                    <div class="card h-100 course-card">
                        <div class="position-relative overflow-hidden" style="height: 220px;">
                            <img src="${curso.imagem_url || '/images/banner-11.jpg'}" class="card-img-top w-100 h-100" 
                                 style="object-fit: cover;" alt="${curso.nome}">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-success">
                                    <i class="fas fa-star me-1"></i>${turmasDocu.length} Turma${turmasDocu.length !== 1 ? 's' : ''}
                                </span>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title">${curso.nome}</h5>
                            <p class="card-text text-muted small mb-3">${curso.descricao || 'Descricao do curso'}</p>
                            
                            <div class="course-info mb-3">
                                <span class="badge bg-light text-dark me-2 mb-2">
                                    <i class="fas fa-book me-1"></i>${curso.area || 'Área'}
                                </span>
                                <span class="badge bg-light text-dark mb-2">
                                    <i class="fas fa-desktop me-1"></i>${curso.modalidade || 'Modalidade'}
                                </span>
                            </div>
                            
                            <div class="course-stats mb-3">
                                <small class="text-muted d-block">
                                    <i class="fas fa-users me-1"></i>
                                    Vagas: <strong>${totalVagas - totalPreenchidas}</strong> de <strong>${totalVagas}</strong>
                                </small>
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: ${totalVagas ? (totalPreenchidas / totalVagas * 100) : 0}%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-white border-top">
                            <a href="#" class="btn btn-primary btn-sm w-100" 
                               onclick="mostrarTurmas(${curso.id}, '${curso.nome}')">
                                <i class="fas fa-calendar-alt me-2"></i>Ver Turmas Disponíveis
                            </a>
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        container.innerHTML = html;
        if (typeof AOS !== 'undefined') {
            AOS.refresh();
        }
    }
    
    function mostrarTurmas(cursoId, cursoNome) {
        fetch(`/turmas?curso_id=${cursoId}&publicado=true`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(r => r.json())
            .then(data => {
                const turmas = data.data || data;
                
                let html = '<div class="row g-3">';
                turmas.forEach(turma => {
                    const vagas = turma.vagas_totais ? (turma.vagas_totais - (turma.vagas_preenchidas || 0)) : '—';
                    html += `
                        <div class="col-12">
                            <div class="border rounded p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h6 class="mb-2">${turma.periodo?.toUpperCase() || 'PERÍODO'}</h6>
                                        <p class="text-muted small mb-2">
                                            <i class="fas fa-calendar me-1"></i>
                                            Arranque: <strong>${new Date(turma.data_arranque).toLocaleDateString('pt-PT')}</strong>
                                        </p>
                                        <p class="text-muted small mb-0">
                                            <i class="fas fa-clock me-1"></i>
                                            ${turma.hora_inicio} - ${turma.hora_fim}
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <p class="mb-2">
                                            <span class="badge bg-warning text-dark">
                                                ${vagas} vagas
                                            </span>
                                        </p>
                                        <button class="btn btn-sm btn-primary" onclick="abrirModalPreInscricao(${turma.id})">
                                            <i class="fas fa-edit me-1"></i>Inscrever-se
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                
                Swal.fire({
                    title: `Turmas - ${cursoNome}`,
                    html: html,
                    width: 700,
                    showCloseButton: true,
                    confirmButtonText: 'Fechar'
                });
            });
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
    
    function limparFiltros() {
        document.getElementById('filtro-busca').value = '';
        document.getElementById('filtro-area').value = '';
        document.getElementById('filtro-centro').value = '';
        document.querySelector('input[name="modalidade"]').checked = true;
        aplicarFiltros();
    }
    
    // Event listeners
    document.addEventListener('DOMContentLoaded', () => {
        carregarFiltros();
        // Não recarregar com aplicarFiltros() - os dados já vêm do servidor renderizados
        
        document.getElementById('filtro-busca').addEventListener('input', aplicarFiltros);
        document.querySelectorAll('.filtro-modalidade').forEach(el => {
            el.addEventListener('change', aplicarFiltros);
        });
        document.getElementById('filtro-area').addEventListener('change', aplicarFiltros);
        document.getElementById('filtro-centro').addEventListener('change', aplicarFiltros);
    });
</script>
@endsection
