@extends('layouts.public')

@section('title', 'Contactos - MC-COMERCIAL')

@section('content')
<div class="py-12 bg-background min-h-screen">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h1 class="section-title">Contacte-nos</h1>
            <p class="section-subtitle">Estamos aqui para ajudá-lo</p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
            {{-- Formulário --}}
            <div class="feature-card" x-data="contactForm()">
                <h3 class="text-xl font-bold text-foreground mb-6">Envie-nos uma mensagem</h3>
                <form @submit.prevent="submitForm">
                    @csrf
                    <div class="space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="nome" class="text-sm font-medium text-foreground mb-1 block">Nome Completo *</label>
                                <input id="nome" type="text" x-model="form.nome" placeholder="Seu nome"
                                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring">
                            </div>
                            <div>
                                <label for="email" class="text-sm font-medium text-foreground mb-1 block">Email *</label>
                                <input id="email" type="email" x-model="form.email" placeholder="seuemail@exemplo.com"
                                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring">
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="telefone" class="text-sm font-medium text-foreground mb-1 block">Telefone</label>
                                <input id="telefone" type="text" x-model="form.telefone" placeholder="+244 9XX-XXX-XXX"
                                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring">
                            </div>
                            <div>
                                <label for="assunto" class="text-sm font-medium text-foreground mb-1 block">Assunto *</label>
                                <select x-model="form.assunto"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                                    <option value="">Selecione</option>
                                    <option value="geral">Geral</option>
                                    <option value="cursos">Cursos</option>
                                    <option value="produtos">Produtos</option>
                                    <option value="servicos">Serviços</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="mensagem" class="text-sm font-medium text-foreground mb-1 block">Mensagem *</label>
                            <textarea id="mensagem" rows="5" x-model="form.mensagem" placeholder="Escreva a sua mensagem..."
                                      class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring resize-none"></textarea>
                        </div>
                        <button type="submit" :disabled="loading"
                                class="w-full inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground h-10 hover:bg-primary/90 transition-colors disabled:opacity-50">
                            <i data-lucide="send" class="w-4 h-4 mr-2"></i>
                            <span x-show="!loading">Enviar Mensagem</span>
                            <span x-show="loading">Enviando...</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Info lateral --}}
            <div class="space-y-6">
                <div class="feature-card">
                    <h3 class="text-xl font-bold text-foreground mb-4">Sobre a MC-COMERCIAL</h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">
                        Com mais de 10 anos de experiência, a MC-COMERCIAL é um centro de formação de referência em Angola, dedicado à preparação de profissionais qualificados para o mercado de trabalho. A nossa missão é transformar vidas através da educação e formação de qualidade.
                    </p>
                </div>

                <div class="feature-card">
                    <h3 class="text-xl font-bold text-foreground mb-4">Informações de Contacto</h3>
                    <div class="space-y-3">
                        <a href="tel:+244929643510" class="flex items-center gap-3 text-sm text-muted-foreground hover:text-accent transition-colors">
                            <i data-lucide="phone" class="w-5 h-5 text-accent"></i>+244 929-643-510
                        </a>
                        <a href="tel:+244928966002" class="flex items-center gap-3 text-sm text-muted-foreground hover:text-accent transition-colors">
                            <i data-lucide="phone" class="w-5 h-5 text-accent"></i>+244 928-966-002
                        </a>
                        <a href="mailto:mucuanha.chineva@gmail.com" class="flex items-center gap-3 text-sm text-muted-foreground hover:text-accent transition-colors">
                            <i data-lucide="mail" class="w-5 h-5 text-accent"></i>mucuanha.chineva@gmail.com
                        </a>
                        <p class="flex items-start gap-3 text-sm text-muted-foreground">
                            <i data-lucide="map-pin" class="w-5 h-5 text-accent shrink-0"></i>Rua A, Bairro 1º de Maio Nº 05, 1º Andar, Luanda-Viana
                        </p>
                    </div>
                </div>

                <div class="feature-card">
                    <h3 class="text-xl font-bold text-foreground mb-4">Horário de Funcionamento</h3>
                    <div class="space-y-2 text-sm text-muted-foreground">
                        <p class="flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4 text-accent"></i>Segunda - Sexta: 8h00 - 18h00</p>
                        <p class="flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4 text-accent"></i>Sábado: 9h00 - 16h00</p>
                        <p class="flex items-center gap-2"><i data-lucide="clock" class="w-4 h-4 text-accent"></i>Domingo: Encerrado</p>
                    </div>
                </div>

                <div class="feature-card">
                    <h3 class="text-xl font-bold text-foreground mb-4">Contacto Rápido</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="https://wa.me/244929643510" target="_blank" rel="noopener noreferrer"
                           class="flex items-center justify-center gap-2 bg-success/10 text-success rounded-lg p-3 text-sm font-medium hover:bg-success/20 transition-colors">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>WhatsApp
                        </a>
                        <a href="tel:+244929643510"
                           class="flex items-center justify-center gap-2 bg-accent/10 text-accent rounded-lg p-3 text-sm font-medium hover:bg-accent/20 transition-colors">
                            <i data-lucide="phone" class="w-5 h-5"></i>Ligar
                        </a>
                        <a href="mailto:mucuanha.chineva@gmail.com"
                           class="flex items-center justify-center gap-2 bg-primary/10 text-primary rounded-lg p-3 text-sm font-medium hover:bg-primary/20 transition-colors">
                            <i data-lucide="mail" class="w-5 h-5"></i>Email
                        </a>
                        <a href="#"
                           class="flex items-center justify-center gap-2 bg-accent/10 text-accent rounded-lg p-3 text-sm font-medium hover:bg-accent/20 transition-colors">
                            <i data-lucide="facebook" class="w-5 h-5"></i>Facebook
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function contactForm() {
    return {
        form: { nome: '', email: '', telefone: '', assunto: '', mensagem: '' },
        loading: false,
        async submitForm() {
            if (!this.form.nome.trim()) return showToast('Nome é obrigatório', 'error');
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.email)) return showToast('Email inválido', 'error');
            if (!this.form.assunto) return showToast('Selecione um assunto', 'error');
            if (!this.form.mensagem.trim()) return showToast('Mensagem é obrigatória', 'error');

            this.loading = true;
            try {
                const response = await fetch('/api/contactos', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify(this.form)
                });
                if (response.ok) {
                    showToast('Mensagem enviada com sucesso! Entraremos em contacto brevemente.');
                    this.form = { nome: '', email: '', telefone: '', assunto: '', mensagem: '' };
                } else {
                    showToast('Erro ao enviar. Tente novamente.', 'error');
                }
            } catch (e) {
                showToast('Erro de conexão.', 'error');
            }
            this.loading = false;
        }
    }
}
</script>
@endpush
