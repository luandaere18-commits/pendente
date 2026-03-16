@extends('layouts.public')

@section('title', 'Contactos - MC-COMERCIAL')

@section('content')

{{-- Page Hero --}}
<div class="page-hero text-center">
    <div class="container mx-auto px-4 relative z-10">
        <span class="section-tag text-accent-foreground/80 justify-center before:bg-white/40">
            <i data-lucide="mail" class="w-3.5 h-3.5"></i> Fale Connosco
        </span>
        <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-5" style="letter-spacing: -0.03em;">Contacte-nos</h1>
        <p class="text-lg text-white/65 max-w-2xl mx-auto">Estamos aqui para o ajudar. Fale connosco hoje mesmo.</p>
    </div>
</div>

<div class="py-16 bg-background min-h-screen">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-5 gap-10">

            {{-- Formulário --}}
            <div class="lg:col-span-3">
                <div class="feature-card reveal"
                     x-data="{
                         form: { nome: '', email: '', telefone: '', assunto: '', mensagem: '' },
                         loading: false,
                         submitted: false,
                         touched: {},
                         errors: {},
                         validEmail() { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.email); },
                         touch(field) { this.touched[field] = true; },
                         validate() {
                             this.touched = { nome: true, email: true, assunto: true, mensagem: true };
                             return this.form.nome.length >= 2 && this.validEmail()
                                    && this.form.assunto && this.form.mensagem.length >= 10;
                         },
                         filledCount() {
                             return [this.form.nome.length >= 2, this.validEmail(), !!this.form.assunto, this.form.mensagem.length >= 10].filter(Boolean).length;
                         },
                         async submitForm() {
                             if (!this.validate()) {
                                 showToast('Por favor preencha todos os campos obrigatórios.', 'error');
                                 return;
                             }
                             this.loading = true;
                             await new Promise(r => setTimeout(r, 1500));
                             this.submitted = true;
                             this.loading = false;
                             showToast('Mensagem enviada com sucesso! Entraremos em contacto brevemente.', 'success');
                         }
                     }">

                    {{-- Success --}}
                    <div x-show="submitted" class="text-center py-12">
                        <div class="w-20 h-20 rounded-full bg-success/10 flex items-center justify-center mx-auto mb-5 animate-scale-in">
                            <i data-lucide="check-circle-2" class="w-10 h-10 text-success"></i>
                        </div>
                        <h3 class="text-xl font-extrabold text-foreground mb-2">Mensagem Enviada!</h3>
                        <p class="text-sm text-muted-foreground mb-6">A sua mensagem foi enviada com sucesso. Respondemos em até 24 horas úteis.</p>
                        <button @click="submitted = false; form = { nome: '', email: '', telefone: '', assunto: '', mensagem: '' }; touched = {};"
                                class="btn-ghost">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>Enviar outra mensagem
                        </button>
                    </div>

                    {{-- Form --}}
                    <div x-show="!submitted">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="icon-box icon-box-sm bg-accent/10">
                                <i data-lucide="send" class="w-5 h-5 text-accent"></i>
                            </div>
                            <h3 class="text-xl font-extrabold text-foreground">Envie-nos uma mensagem</h3>
                        </div>

                        <form @submit.prevent="submitForm()" class="space-y-5">
                            <div class="grid md:grid-cols-2 gap-5">
                                <div>
                                    <label class="text-sm font-bold text-foreground mb-2 block">
                                        Nome Completo <span class="text-destructive">*</span>
                                    </label>
                                    <div class="relative">
                                        <i data-lucide="user" class="input-icon"></i>
                                        <input type="text" x-model="form.nome" @blur="touch('nome')" placeholder="Seu nome"
                                               class="input-field pl-11"
                                               :class="touched.nome && form.nome.length < 2 ? 'border-destructive focus:ring-destructive/30' : ''">
                                    </div>
                                    <p class="text-xs text-destructive mt-1" x-show="touched.nome && form.nome.length < 2">Nome muito curto</p>
                                </div>
                                <div>
                                    <label class="text-sm font-bold text-foreground mb-2 block">
                                        Email <span class="text-destructive">*</span>
                                    </label>
                                    <div class="relative">
                                        <i data-lucide="mail" class="input-icon"></i>
                                        <input type="email" x-model="form.email" @blur="touch('email')" placeholder="email@exemplo.com"
                                               class="input-field pl-11"
                                               :class="touched.email && !validEmail() ? 'border-destructive focus:ring-destructive/30' : ''">
                                    </div>
                                    <p class="text-xs text-destructive mt-1" x-show="touched.email && !validEmail()">Email inválido</p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-5">
                                <div>
                                    <label class="text-sm font-bold text-foreground mb-2 block">Telefone <span class="text-muted-foreground font-normal">(opcional)</span></label>
                                    <div class="relative">
                                        <i data-lucide="phone" class="input-icon"></i>
                                        <input type="text" x-model="form.telefone" placeholder="+244 9XX-XXX-XXX"
                                               class="input-field pl-11">
                                    </div>
                                </div>
                                <div>
                                    <label class="text-sm font-bold text-foreground mb-2 block">
                                        Assunto <span class="text-destructive">*</span>
                                    </label>
                                    <select x-model="form.assunto" @blur="touch('assunto')"
                                            class="input-field"
                                            :class="touched.assunto && !form.assunto ? 'border-destructive' : ''">
                                        <option value="">Selecione um assunto</option>
                                        <option value="geral">Informações Gerais</option>
                                        <option value="cursos">Turmas e Inscrições</option>
                                        <option value="produtos">Produtos</option>
                                        <option value="servicos">Serviços</option>
                                        <option value="parceria">Parcerias</option>
                                    </select>
                                    <p class="text-xs text-destructive mt-1" x-show="touched.assunto && !form.assunto">Selecione um assunto</p>
                                </div>
                            </div>

                            <div>
                                <label class="text-sm font-bold text-foreground mb-2 flex items-center justify-between">
                                    <span>Mensagem <span class="text-destructive">*</span></span>
                                    <span class="text-xs text-muted-foreground font-normal tabular-nums" x-text="`${form.mensagem.length}/500`"></span>
                                </label>
                                <textarea x-model="form.mensagem" @blur="touch('mensagem')" rows="5" maxlength="500"
                                          placeholder="Escreva a sua mensagem aqui... (mínimo 10 caracteres)"
                                          class="input-field h-auto resize-none"
                                          :class="touched.mensagem && form.mensagem.length < 10 ? 'border-destructive focus:ring-destructive/30' : ''"></textarea>
                                <p class="text-xs text-destructive mt-1" x-show="touched.mensagem && form.mensagem.length < 10">Mínimo de 10 caracteres</p>
                            </div>

                            {{-- Progress dots --}}
                            <div class="flex items-center gap-3 text-xs text-muted-foreground">
                                <div class="flex gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full transition-colors duration-400" :class="form.nome.length >= 2 ? 'bg-success' : 'bg-muted'"></span>
                                    <span class="w-2.5 h-2.5 rounded-full transition-colors duration-400" :class="validEmail() ? 'bg-success' : 'bg-muted'"></span>
                                    <span class="w-2.5 h-2.5 rounded-full transition-colors duration-400" :class="form.assunto ? 'bg-success' : 'bg-muted'"></span>
                                    <span class="w-2.5 h-2.5 rounded-full transition-colors duration-400" :class="form.mensagem.length >= 10 ? 'bg-success' : 'bg-muted'"></span>
                                </div>
                                <span x-text="`${filledCount()}/4 campos preenchidos`"></span>
                            </div>

                            <button type="submit"
                                    class="btn-primary w-full h-13"
                                    :class="loading ? 'opacity-80 cursor-wait' : ''">
                                <span x-show="!loading" class="flex items-center gap-2">
                                    <i data-lucide="send" class="w-4 h-4"></i>Enviar Mensagem
                                </span>
                                <span x-show="loading" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    A enviar mensagem...
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Info lateral --}}
            <div class="lg:col-span-2 space-y-5">

                <div class="feature-card reveal">
                    <h3 class="font-extrabold text-foreground mb-3 flex items-center gap-2.5">
                        <div class="icon-box icon-box-sm bg-accent/10">
                            <i data-lucide="info" class="w-4 h-4 text-accent"></i>
                        </div>
                        Sobre a MC-COMERCIAL
                    </h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">
                        Com mais de 10 anos de experiência, a MC-COMERCIAL é um centro de formação de referência em Angola, dedicado à preparação de profissionais qualificados para o mercado de trabalho.
                    </p>
                </div>

                <div class="feature-card reveal">
                    <h3 class="font-extrabold text-foreground mb-5 flex items-center gap-2.5">
                        <div class="icon-box icon-box-sm bg-accent/10">
                            <i data-lucide="phone" class="w-4 h-4 text-accent"></i>
                        </div>
                        Informações de Contacto
                    </h3>
                    <div class="space-y-3">
                        @foreach([
                            ['icon' => 'phone', 'href' => 'tel:+244929643510', 'text' => '+244 929-643-510'],
                            ['icon' => 'phone', 'href' => 'tel:+244928966002', 'text' => '+244 928-966-002'],
                            ['icon' => 'mail',  'href' => 'mailto:mucuanha.chineva@gmail.com', 'text' => 'mucuanha.chineva@gmail.com'],
                        ] as $contact)
                            <a href="{{ $contact['href'] }}"
                               class="flex items-center gap-3 text-sm text-muted-foreground hover:text-accent hover:translate-x-1 transition-all duration-300 group">
                                <div class="icon-box icon-box-sm bg-accent/10 group-hover:bg-accent transition-colors duration-300">
                                    <i data-lucide="{{ $contact['icon'] }}" class="w-3.5 h-3.5 text-accent group-hover:text-white transition-colors"></i>
                                </div>
                                {{ $contact['text'] }}
                            </a>
                        @endforeach
                        <div class="flex items-start gap-3 text-sm text-muted-foreground pt-1">
                            <div class="icon-box icon-box-sm bg-accent/10">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-accent"></i>
                            </div>
                            <span>Rua A, Bairro 1º de Maio Nº 05, 1º Andar, Luanda-Viana</span>
                        </div>
                    </div>
                </div>

                <div class="feature-card reveal">
                    <h3 class="font-extrabold text-foreground mb-5 flex items-center gap-2.5">
                        <div class="icon-box icon-box-sm bg-accent/10">
                            <i data-lucide="clock" class="w-4 h-4 text-accent"></i>
                        </div>
                        Horário de Funcionamento
                    </h3>
                    <div class="space-y-2">
                        @foreach([
                            ['day' => 'Segunda - Sexta', 'time' => '8h00 - 18h00', 'open' => true],
                            ['day' => 'Sábado',          'time' => '9h00 - 16h00', 'open' => true],
                            ['day' => 'Domingo',         'time' => 'Encerrado',    'open' => false],
                        ] as $h)
                            <div class="flex items-center justify-between py-2.5 border-b border-border last:border-0 text-sm rounded-lg px-2 hover:bg-muted/30 transition-colors">
                                <span class="text-muted-foreground">{{ $h['day'] }}</span>
                                <span class="{{ $h['open'] ? 'text-foreground font-bold' : 'text-destructive font-bold' }} tabular-nums">{{ $h['time'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="feature-card reveal">
                    <h3 class="font-extrabold text-foreground mb-5 flex items-center gap-2.5">
                        <div class="icon-box icon-box-sm bg-accent/10">
                            <i data-lucide="zap" class="w-4 h-4 text-accent"></i>
                        </div>
                        Contacto Rápido
                    </h3>
                    <div class="grid grid-cols-2 gap-2.5">
                        <a href="https://wa.me/244929643510" target="_blank" rel="noopener noreferrer"
                           class="flex items-center justify-center gap-2 rounded-xl p-3.5 text-sm font-bold hover:scale-105 transition-all duration-300"
                           style="background-color: rgba(37,211,102,0.1); color:#25D366;">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>WhatsApp
                        </a>
                        <a href="tel:+244929643510"
                           class="flex items-center justify-center gap-2 bg-accent/10 text-accent rounded-xl p-3.5 text-sm font-bold hover:bg-accent hover:text-white hover:scale-105 transition-all duration-300">
                            <i data-lucide="phone" class="w-4 h-4"></i>Ligar
                        </a>
                        <a href="mailto:mucuanha.chineva@gmail.com"
                           class="flex items-center justify-center gap-2 bg-primary/10 text-primary rounded-xl p-3.5 text-sm font-bold hover:bg-primary hover:text-white hover:scale-105 transition-all duration-300">
                            <i data-lucide="mail" class="w-4 h-4"></i>Email
                        </a>
                        <a href="#"
                           class="flex items-center justify-center gap-2 bg-blue-500/10 text-blue-600 rounded-xl p-3.5 text-sm font-bold hover:bg-blue-500 hover:text-white hover:scale-105 transition-all duration-300">
                            <i data-lucide="facebook" class="w-4 h-4"></i>Facebook
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
