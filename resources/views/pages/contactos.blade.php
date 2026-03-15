@extends('layouts.public')

@section('title', 'Contactos - MC-COMERCIAL')

@section('content')

{{-- Page Hero (azul centralizado) --}}
<div class="bg-gradient-to-br from-primary via-primary/90 to-primary/80 py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-accent blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 text-center text-primary-foreground relative">
        <h1 class="text-4xl lg:text-5xl font-extrabold mb-4">Contacte-nos</h1>
        <p class="text-lg opacity-80 max-w-2xl mx-auto">Estamos aqui para o ajudar. Fale connosco hoje mesmo.</p>
    </div>
</div>

<div class="py-14 bg-background min-h-screen">
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
                    <div x-show="submitted" class="text-center py-10">
                        <div class="w-20 h-20 rounded-full bg-success/10 flex items-center justify-center mx-auto mb-5">
                            <i data-lucide="check-circle-2" class="w-10 h-10 text-success"></i>
                        </div>
                        <h3 class="text-xl font-bold text-foreground mb-2">Mensagem Enviada!</h3>
                        <p class="text-sm text-muted-foreground mb-6">A sua mensagem foi enviada com sucesso. Respondemos em até 24 horas úteis.</p>
                        <button @click="submitted = false; form = { nome: '', email: '', telefone: '', assunto: '', mensagem: '' }; touched = {};"
                                class="inline-flex items-center gap-2 rounded-xl text-sm font-semibold border border-input bg-background h-10 px-5 hover:bg-muted transition-all">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>Enviar outra mensagem
                        </button>
                    </div>

                    {{-- Form --}}
                    <div x-show="!submitted">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-accent/10 flex items-center justify-center">
                                <i data-lucide="send" class="w-5 h-5 text-accent"></i>
                            </div>
                            <h3 class="text-xl font-bold text-foreground">Envie-nos uma mensagem</h3>
                        </div>

                        <form @submit.prevent="submitForm()" class="space-y-4">
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-semibold text-foreground mb-1.5 block">
                                        Nome Completo <span class="text-destructive">*</span>
                                    </label>
                                    <div class="relative">
                                        <i data-lucide="user" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground"></i>
                                        <input type="text" x-model="form.nome" @blur="touch('nome')" placeholder="Seu nome"
                                               class="flex h-11 w-full rounded-xl border pl-10 pr-3 py-2 text-sm bg-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring transition-all"
                                               :class="touched.nome && form.nome.length < 2 ? 'border-destructive focus:ring-destructive/30' : 'border-input'">
                                    </div>
                                    <p class="text-xs text-destructive mt-1" x-show="touched.nome && form.nome.length < 2">Nome muito curto</p>
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-foreground mb-1.5 block">
                                        Email <span class="text-destructive">*</span>
                                    </label>
                                    <div class="relative">
                                        <i data-lucide="mail" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground"></i>
                                        <input type="email" x-model="form.email" @blur="touch('email')" placeholder="email@exemplo.com"
                                               class="flex h-11 w-full rounded-xl border pl-10 pr-3 py-2 text-sm bg-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring transition-all"
                                               :class="touched.email && !validEmail() ? 'border-destructive focus:ring-destructive/30' : 'border-input'">
                                    </div>
                                    <p class="text-xs text-destructive mt-1" x-show="touched.email && !validEmail()">Email inválido</p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-semibold text-foreground mb-1.5 block">Telefone <span class="text-muted-foreground font-normal">(opcional)</span></label>
                                    <div class="relative">
                                        <i data-lucide="phone" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground"></i>
                                        <input type="text" x-model="form.telefone" placeholder="+244 9XX-XXX-XXX"
                                               class="flex h-11 w-full rounded-xl border border-input pl-10 pr-3 py-2 text-sm bg-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring transition-all">
                                    </div>
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-foreground mb-1.5 block">
                                        Assunto <span class="text-destructive">*</span>
                                    </label>
                                    <select x-model="form.assunto" @blur="touch('assunto')"
                                            class="flex h-11 w-full rounded-xl border bg-background px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-all"
                                            :class="touched.assunto && !form.assunto ? 'border-destructive' : 'border-input'">
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
                                <label class="text-sm font-semibold text-foreground mb-1.5 flex items-center justify-between">
                                    <span>Mensagem <span class="text-destructive">*</span></span>
                                    <span class="text-xs text-muted-foreground font-normal" x-text="`${form.mensagem.length}/500`"></span>
                                </label>
                                <textarea x-model="form.mensagem" @blur="touch('mensagem')" rows="5" maxlength="500"
                                          placeholder="Escreva a sua mensagem aqui... (mínimo 10 caracteres)"
                                          class="flex w-full rounded-xl border bg-background px-4 py-3 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring resize-none transition-all"
                                          :class="touched.mensagem && form.mensagem.length < 10 ? 'border-destructive focus:ring-destructive/30' : 'border-input'"></textarea>
                                <p class="text-xs text-destructive mt-1" x-show="touched.mensagem && form.mensagem.length < 10">Mínimo de 10 caracteres</p>
                            </div>

                            {{-- Progress dots --}}
                            <div class="flex items-center gap-3 text-xs text-muted-foreground">
                                <div class="flex gap-1.5">
                                    <span class="w-2 h-2 rounded-full transition-colors duration-300" :class="form.nome.length >= 2 ? 'bg-success' : 'bg-muted'"></span>
                                    <span class="w-2 h-2 rounded-full transition-colors duration-300" :class="validEmail() ? 'bg-success' : 'bg-muted'"></span>
                                    <span class="w-2 h-2 rounded-full transition-colors duration-300" :class="form.assunto ? 'bg-success' : 'bg-muted'"></span>
                                    <span class="w-2 h-2 rounded-full transition-colors duration-300" :class="form.mensagem.length >= 10 ? 'bg-success' : 'bg-muted'"></span>
                                </div>
                                <span x-text="`${filledCount()}/4 campos preenchidos`"></span>
                            </div>

                            {{-- Botão sempre activo --}}
                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl text-sm font-bold bg-primary text-primary-foreground h-12 hover:bg-primary/90 active:scale-95 transition-all duration-200 shadow-sm hover:shadow-md"
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
                    <h3 class="font-bold text-foreground mb-3 flex items-center gap-2">
                        <i data-lucide="info" class="w-4 h-4 text-accent"></i>
                        Sobre a MC-COMERCIAL
                    </h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">
                        Com mais de 10 anos de experiência, a MC-COMERCIAL é um centro de formação de referência em Angola, dedicado à preparação de profissionais qualificados para o mercado de trabalho.
                    </p>
                </div>

                <div class="feature-card reveal">
                    <h3 class="font-bold text-foreground mb-4 flex items-center gap-2">
                        <i data-lucide="phone" class="w-4 h-4 text-accent"></i>
                        Informações de Contacto
                    </h3>
                    <div class="space-y-3">
                        @foreach([
                            ['icon' => 'phone', 'href' => 'tel:+244929643510', 'text' => '+244 929-643-510'],
                            ['icon' => 'phone', 'href' => 'tel:+244928966002', 'text' => '+244 928-966-002'],
                            ['icon' => 'mail',  'href' => 'mailto:mucuanha.chineva@gmail.com', 'text' => 'mucuanha.chineva@gmail.com'],
                        ] as $contact)
                            <a href="{{ $contact['href'] }}"
                               class="flex items-center gap-3 text-sm text-muted-foreground hover:text-accent hover:translate-x-1 transition-all duration-200 group">
                                <div class="w-8 h-8 rounded-lg bg-accent/10 group-hover:bg-accent flex items-center justify-center shrink-0 transition-colors">
                                    <i data-lucide="{{ $contact['icon'] }}" class="w-3.5 h-3.5 text-accent group-hover:text-white transition-colors"></i>
                                </div>
                                {{ $contact['text'] }}
                            </a>
                        @endforeach
                        <div class="flex items-start gap-3 text-sm text-muted-foreground pt-1">
                            <div class="w-8 h-8 rounded-lg bg-accent/10 flex items-center justify-center shrink-0">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-accent"></i>
                            </div>
                            <span>Rua A, Bairro 1º de Maio Nº 05, 1º Andar, Luanda-Viana</span>
                        </div>
                    </div>
                </div>

                <div class="feature-card reveal">
                    <h3 class="font-bold text-foreground mb-4 flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4 text-accent"></i>
                        Horário de Funcionamento
                    </h3>
                    <div class="space-y-2">
                        @foreach([
                            ['day' => 'Segunda - Sexta', 'time' => '8h00 - 18h00', 'open' => true],
                            ['day' => 'Sábado',          'time' => '9h00 - 16h00', 'open' => true],
                            ['day' => 'Domingo',         'time' => 'Encerrado',    'open' => false],
                        ] as $h)
                            <div class="flex items-center justify-between py-2 border-b border-border last:border-0 text-sm">
                                <span class="text-muted-foreground">{{ $h['day'] }}</span>
                                <span class="{{ $h['open'] ? 'text-foreground font-semibold' : 'text-destructive font-semibold' }}">{{ $h['time'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="feature-card reveal">
                    <h3 class="font-bold text-foreground mb-4 flex items-center gap-2">
                        <i data-lucide="zap" class="w-4 h-4 text-accent"></i>
                        Contacto Rápido
                    </h3>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="https://wa.me/244929643510" target="_blank" rel="noopener noreferrer"
                           class="flex items-center justify-center gap-2 rounded-xl p-3 text-sm font-semibold hover:scale-105 active:scale-95 transition-all duration-200"
                           style="background-color: rgba(37,211,102,0.1); color:#25D366;">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>WhatsApp
                        </a>
                        <a href="tel:+244929643510"
                           class="flex items-center justify-center gap-2 bg-accent/10 text-accent rounded-xl p-3 text-sm font-semibold hover:bg-accent hover:text-white hover:scale-105 transition-all duration-200">
                            <i data-lucide="phone" class="w-4 h-4"></i>Ligar
                        </a>
                        <a href="mailto:mucuanha.chineva@gmail.com"
                           class="flex items-center justify-center gap-2 bg-primary/10 text-primary rounded-xl p-3 text-sm font-semibold hover:bg-primary hover:text-white hover:scale-105 transition-all duration-200">
                            <i data-lucide="mail" class="w-4 h-4"></i>Email
                        </a>
                        <a href="#"
                           class="flex items-center justify-center gap-2 bg-blue-500/10 text-blue-600 rounded-xl p-3 text-sm font-semibold hover:bg-blue-500 hover:text-white hover:scale-105 transition-all duration-200">
                            <i data-lucide="facebook" class="w-4 h-4"></i>Facebook
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
