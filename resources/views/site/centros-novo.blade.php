@extends('layouts.public')

@section('title', 'Centros de Formação')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 class="page-title">Centros de Formação</h1>
        <p class="page-subtitle">Encontre o centro mais próximo de si</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Centros</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Centros Grid -->
<section class="section">
    <div class="container">
        <div class="row g-4" id="centros-grid">
            <div class="col-12">
                <div class="loading">
                    <div class="spinner"></div>
                    <p>Carregando centros...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="section bg-light" id="mapa-centros">
    <div class="container">
        <h2 class="section-title mb-4">Localizações</h2>
        <div class="ratio ratio-16x9">
            <iframe src="https://maps.google.com/maps?q=Luanda+Viana&t=&z=12&ie=UTF8&iwloc=&output=embed" 
                    style="border:0; border-radius: 1rem;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    async function carregarCentros() {
        try {
            const response = await fetch('/centros', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const centros = await response.json();
            
            const container = document.getElementById('centros-grid');
            
            if (centros.length === 0) {
                container.innerHTML = '<div class="col-12 text-center text-muted"><p>Nenhum centro disponível</p></div>';
                return;
            }
            
            let html = '';
            centros.forEach((centro, index) => {
                html += `
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="${index * 100}">
                        <div class="card h-100 feature-card">
                            <div class="card-header bg-gradient" style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
                                <h4 class="text-white mb-0">
                                    <i class="fas fa-building me-2"></i>${centro.nome}
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="info-item mb-3">
                                    <h6 class="text-muted mb-1">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>Localização
                                    </h6>
                                    <p class="mb-0">${centro.localizacao || 'Localização disponível'}</p>
                                </div>
                                
                                <div class="info-item mb-3">
                                    <h6 class="text-muted mb-1">
                                        <i class="fas fa-phone me-2 text-primary"></i>Contacto
                                    </h6>
                                    <div>
                                        ${centro.contactos?.map((tel, i) => `
                                            <a href="tel:${tel}" class="d-block text-decoration-none mb-1">
                                                <i class="fas fa-phone-alt me-1"></i>${tel}
                                            </a>
                                        `).join('') || '<p class="mb-0">Contacto disponível</p>'}
                                    </div>
                                </div>
                                
                                <div class="info-item mb-3">
                                    <h6 class="text-muted mb-1">
                                        <i class="fas fa-envelope me-2 text-primary"></i>Email
                                    </h6>
                                    ${centro.email ? `
                                        <a href="mailto:${centro.email}" class="text-decoration-none">
                                            ${centro.email}
                                        </a>
                                    ` : '<p class="mb-0">Email disponível</p>'}
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top">
                                <a href="/site/centro/${centro.id}" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-arrow-right me-2"></i>Ver Detalhes
                                </a>
                                <button class="btn btn-outline-secondary btn-sm w-100 mt-2" onclick="abrirMapa(${centro.id}, '${centro.localizacao}')">
                                    <i class="fas fa-map me-2"></i>Ver no Mapa
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
            AOS.refresh();
        } catch (error) {
            console.error('Erro ao carregar centros:', error);
            document.getElementById('centros-grid').innerHTML = '<div class="col-12 text-center text-danger"><p>Erro ao carregar centros</p></div>';
        }
    }
    
    function abrirMapa(centroId, localizacao) {
        Swal.fire({
            title: 'Localização',
            html: `
                <div class="ratio ratio-16x9" style="min-height: 400px;">
                    <iframe src="https://maps.google.com/maps?q=${encodeURIComponent(localizacao)}&t=&z=16&ie=UTF8&iwloc=&output=embed" 
                            style="border:0; border-radius: 0.5rem;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            `,
            width: 800,
            showConfirmButton: false,
            showCloseButton: true
        });
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        carregarCentros();
    });
</script>
@endsection
