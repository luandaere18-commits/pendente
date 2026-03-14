@extends('layouts.public')

@section('title', 'Contactos')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 class="page-title">Contacte-nos</h1>
        <p class="page-subtitle">Estamos aqui para ajudar</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Contactos</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Info Cards Section -->
<section class="section">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-lg-4" data-aos="fade-up">
                <div class="card h-100 feature-card border-0">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h5 class="card-title">Localização</h5>
                        <p class="text-muted mb-0">
                            Rua A, Bairro 1º de Maio<br>
                            Luanda-Viana, Angola
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 feature-card border-0">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h5 class="card-title">Telefone</h5>
                        <p class="text-muted mb-0">
                            <a href="tel:+244929643510" class="text-decoration-none">
                                +244 92 964 3510
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 feature-card border-0">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5 class="card-title">Email</h5>
                        <p class="text-muted mb-0">
                            <a href="mailto:info@mc-comercial.ao" class="text-decoration-none">
                                info@mc-comercial.ao
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form and Map Section -->
<section class="section bg-light">
    <div class="container">
        <div class="row g-5 align-items-start">
            <!-- Formulário -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
                        <h5 class="text-white mb-0">
                            <i class="fas fa-paper-plane me-2"></i>Envie-nos uma Mensagem
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="formContacto">
                            <div class="mb-3">
                                <label class="form-label">Nome Completo *</label>
                                <input type="text" class="form-control" name="nome" id="nomeContacto" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" id="emailContacto" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Telefone (Opcional)</label>
                                <input type="tel" class="form-control" name="telefone" id="telefoneContacto" placeholder="+244 9...">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Assunto *</label>
                                <select class="form-select" name="assunto" id="assuntoContacto" required>
                                    <option value="">Selecione um assunto</option>
                                    <option value="inscricao">Dúvida sobre Inscrição</option>
                                    <option value="curso">Informação sobre Curso</option>
                                    <option value="parceria">Proposta de Parceria</option>
                                    <option value="sugestao">Sugestão ou Reclamação</option>
                                    <option value="outro">Outro</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Mensagem *</label>
                                <textarea class="form-control" name="mensagem" id="mensagemContacto" rows="5" required></textarea>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="consentimentoContacto" required>
                                <label class="form-check-label" for="consentimentoContacto">
                                    Concordo em receber resposta via email e/ou telefone
                                </label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-send me-2"></i>Enviar Mensagem
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Mapa -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="card border-0 overflow-hidden" style="height: 500px;">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://maps.google.com/maps?q=Rua+A+Luanda+Viana&t=&z=16&ie=UTF8&iwloc=&output=embed" 
                                style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
                
                <div class="card mt-3 border-0">
                    <div class="card-body">
                        <h6 class="mb-3">
                            <i class="fas fa-clock text-primary me-2"></i>Horário de Funcionamento
                        </h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Segunda a Sexta:</strong> 08:00 - 17:00
                            </li>
                            <li class="mb-2">
                                <strong>Sábado:</strong> 09:00 - 13:00
                            </li>
                            <li>
                                <strong>Domingo:</strong> Fechado
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Centros Section -->
<section class="section">
    <div class="container">
        <h2 class="section-title mb-4 text-center">Visite-nos Nos Nossos Centros</h2>
        <div class="row g-4" id="centros-contacto">
            <div class="col-12">
                <div class="loading">
                    <div class="spinner"></div>
                    <p>Carregando centros...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="section bg-light">
    <div class="container">
        <h2 class="section-title mb-4 text-center">Perguntas Frequentes</h2>
        
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item" data-aos="fade-up">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                                Como posso me inscrever num curso?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Pode fazer pré-inscrição directamente no site, na página de cursos ou contactando-nos via telefone 
                                ou email. Após a pré-inscrição, entraremos em contacto para confirmar os detalhes e dados de pagamento.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                                Qual é a duração dos cursos?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                A duração dos cursos varia de acordo com a área e modalidade. Cursos podem ter duração de 1 a 6 meses. 
                                Verifique os detalhes de cada curso na página de cursos para informações específicas.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                                Os certificados são reconhecidos?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Sim, todos os certificados emitidos pela MC-COMERCIAL são válidos e reconhecidos no mercado profissional. 
                                Emitimos certificados que atestam a conclusão com sucesso dos programas de formação.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                                Qual é a forma de pagamento?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Aceitamos várias formas de pagamento: transferência bancária, depósito em caixa, e em alguns casos 
                                parcelamento. Contacte-nos para conhecer as opções disponíveis para seu caso específico.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="400">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#faq5" aria-expanded="false" aria-controls="faq5">
                                Posso solicitar bolsa de estudo?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Sim, oferecemos bolsas de estudo para candidatos com bom desempenho académico e situação socioeconómica 
                                comprovada. Contacte-nos para mais informações sobre os critérios e processo de candidatura.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Final -->
<section class="section" style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
    <div class="container text-center text-white" data-aos="zoom-in">
        <h2 class="mb-3">Ainda tem dúvidas?</h2>
        <p class="mb-4 fs-5">Não hesite em contactar-nos. A nossa equipa está pronta para o ajudar!</p>
        <div class="d-flex gap-2 justify-content-center flex-wrap">
            <a href="https://wa.me/244929643510?text=Olá%2C%20gostaria%20de%20saber%20mais%20sobre%20os%20cursos" 
               target="_blank" class="btn btn-light btn-lg">
                <i class="fab fa-whatsapp me-2"></i>WhatsApp
            </a>
            <a href="tel:+244929643510" class="btn btn-outline-light btn-lg">
                <i class="fas fa-phone me-2"></i>Ligar
            </a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
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
            
            const container = document.getElementById('centros-contacto');
            
            if (centros.length === 0) {
                container.innerHTML = '<div class="col-12 text-center text-muted"><p>Nenhum centro disponível</p></div>';
                return;
            }
            
            let html = '';
            centros.forEach((centro, index) => {
                html += `
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="${index * 100}">
                        <div class="card h-100 feature-card">
                            <div class="card-header bg-gradient" style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
                                <h5 class="text-white mb-0">
                                    <i class="fas fa-building me-2"></i>${centro.nome}
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <strong>${centro.localizacao || 'Localização'}</strong>
                                </p>
                                <p class="mb-2">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    ${centro.contactos?.map(tel => `
                                        <a href="tel:${tel}" class="text-decoration-none d-block">
                                            ${tel}
                                        </a>
                                    `).join('') || 'N/A'}
                                </p>
                                ${centro.email ? `
                                    <p class="mb-0">
                                        <i class="fas fa-envelope text-primary me-2"></i>
                                        <a href="mailto:${centro.email}" class="text-decoration-none">
                                            ${centro.email}
                                        </a>
                                    </p>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
            AOS.refresh();
        } catch (error) {
            console.error('Erro ao carregar centros:', error);
        }
    }
    
    // Enviar formulário
    document.getElementById('formContacto').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const nome = document.getElementById('nomeContacto').value;
        const email = document.getElementById('emailContacto').value;
        const telefone = document.getElementById('telefoneContacto').value;
        const assunto = document.getElementById('assuntoContacto').value;
        const mensagem = document.getElementById('mensagemContacto').value;
        
        try {
            // Aqui você pode enviar para uma API ou back-end
            // Por enquanto, vamos simular com SweetAlert
            showToast('Mensagem enviada com sucesso! Entraremos em contacto em breve.');
            document.getElementById('formContacto').reset();
        } catch (error) {
            showError('Erro ao enviar mensagem. Por favor, tente novamente.');
        }
    });
    
    document.addEventListener('DOMContentLoaded', () => {
        carregarCentros();
    });
</script>
@endsection
