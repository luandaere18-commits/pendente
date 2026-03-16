{{-- Modal de Pré-Inscrição --}}
<div x-data="{
    open: false,
    turmaId: null,
    turmaNome: '',
    nome_completo: '', email: '', contactos: [''], observacoes: '', termos: false,
    loading: false,
    success: false,
    errors: {},
    validEmail() { return !this.email || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email); },
    canSubmit() { 
        const temContacto = this.contactos.some(c => c.trim().length > 0);
        return this.nome_completo.trim().length >= 2 && temContacto && this.termos && !this.loading;
    },
    openModal(detail) {
        this.turmaId = detail.turmaId;
        this.turmaNome = detail.turmaNome;
        this.nome_completo = ''; this.email = ''; this.contactos = [''];
        this.observacoes = ''; this.termos = false; this.loading = false; this.success = false; this.errors = {};
        this.open = true;
        document.body.style.overflow = 'hidden';
    },
    closeModal() {
        this.open = false;
        document.body.style.overflow = '';
    },
    adicionarContacto() {
        this.contactos.push('');
    },
    removerContacto(index) {
        if (this.contactos.length > 1) {
            this.contactos.splice(index, 1);
        }
    },
    async submitForm() {
        if (!this.canSubmit()) return;
        this.loading = true;
        try {
            const contactosFiltrados = this.contactos.filter(c => c.trim().length > 0);
            const payload = {
                turma_id: this.turmaId,
                nome_completo: this.nome_completo.trim(),
                contactos: contactosFiltrados
            };
            
            if (this.email.trim()) {
                payload.email = this.email.trim();
            }
            if (this.observacoes.trim()) {
                payload.observacoes = this.observacoes.trim();
            }
            
            const r = await fetch('/api/pre-inscricoes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']')?.content
                },
                body: JSON.stringify(payload)
            });
            if (r.ok) {
                this.success = true;
                setTimeout(() => this.closeModal(), 3000);
                showToast('Pré-inscrição realizada com sucesso!', 'success');
            } else {
                const data = await r.json().catch(() => ({}));
                showToast(data.message || 'Erro ao enviar. Tente novamente.', 'error');
            }
        } catch {
            showToast('Erro de conexão. Verifique sua ligação.', 'error');
        } finally {
            this.loading = false;
        }
    }
}" x-show="open" x-cloak
     @pre-inscricao.window="openModal($event.detail)"
     @keydown.escape.window="closeModal()"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4">

    {{-- Overlay --}}
    <div @click="closeModal()"
         class="absolute inset-0 bg-foreground/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    {{-- Dialog --}}
    <div class="relative z-10 w-full max-w-md bg-card rounded-2xl overflow-hidden"
         style="box-shadow: var(--shadow-xl);"
         x-transition:enter="transition ease-out duration-400"
         x-transition:enter-start="opacity-0 scale-90 translate-y-6"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-90 translate-y-6">

        {{-- Header --}}
        <div class="relative px-6 py-6 text-white overflow-hidden" style="background: var(--gradient-hero);">
            <div class="absolute top-0 right-0 w-32 h-32 rounded-full opacity-10" style="background: hsl(var(--accent)); filter: blur(40px);"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2.5 mb-1.5">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                            <i data-lucide="pen-line" class="w-4 h-4"></i>
                        </div>
                        <h2 class="text-lg font-extrabold">Pré-Inscrição</h2>
                    </div>
                    <p class="text-sm opacity-65 pl-10" x-text="turmaNome"></p>
                </div>
                <button @click="closeModal()" class="w-8 h-8 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        {{-- Success state --}}
        <div x-show="success" class="px-6 py-14 text-center">
            <div class="w-20 h-20 rounded-full bg-success/10 flex items-center justify-center mx-auto mb-5 animate-scale-in">
                <i data-lucide="check-circle-2" class="w-10 h-10 text-success"></i>
            </div>
            <h3 class="text-xl font-extrabold text-foreground mb-2">Inscrição Recebida!</h3>
            <p class="text-sm text-muted-foreground">Entraremos em contacto em breve para confirmar a sua inscrição.</p>
        </div>

        {{-- Form --}}
        <div x-show="!success" class="px-6 py-6">
            <form @submit.prevent="submitForm()" class="space-y-4">
                <div>
                    <label class="text-sm font-semibold text-foreground mb-1.5 block">
                        Nome Completo <span class="text-destructive">*</span>
                    </label>
                    <div class="relative">
                        <i data-lucide="user" class="input-icon left-4"></i>
                        <input type="text" x-model="nome_completo" placeholder="Seu nome completo" required
                               class="input-field pl-11"
                               :class="nome_completo && nome_completo.length < 2 ? 'border-destructive focus:ring-destructive/30' : ''">
                    </div>
                    <p class="text-xs text-destructive mt-1" x-show="nome_completo && nome_completo.length < 2">Nome muito curto</p>
                </div>

                <div>
                    <label class="text-sm font-semibold text-foreground mb-1.5 block">
                        Email <span class="text-muted-foreground font-normal">(opcional)</span>
                    </label>
                    <div class="relative">
                        <i data-lucide="mail" class="input-icon left-4"></i>
                        <input type="email" x-model="email" placeholder="seuemail@exemplo.com"
                               class="input-field pl-11"
                               :class="email && !validEmail() ? 'border-destructive focus:ring-destructive/30' : ''">
                    </div>
                    <p class="text-xs text-destructive mt-1" x-show="email && !validEmail()">Endereço de email inválido</p>
                </div>

                <div>
                    <label class="text-sm font-semibold text-foreground mb-1.5 block">
                        Contactos <span class="text-destructive">*</span>
                    </label>
                    <div id="contactos-container" class="space-y-2.5">
                        <template x-for="(contacto, index) in contactos" :key="index">
                            <div class="flex gap-2.5 contacto-item">
                                <div class="relative flex-1">
                                    <i data-lucide="phone" class="input-icon left-4"></i>
                                    <input type="text" x-model="contactos[index]" placeholder="Ex: +244 923-456-789"
                                           class="input-field pl-11" required>
                                </div>
                                <button type="button" 
                                        @click="removerContacto(index)"
                                        x-show="contactos.length > 1"
                                        class="px-3 py-2 bg-destructive/10 text-destructive rounded-lg hover:bg-destructive/20 transition-all">
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                                <button type="button" 
                                        @click="adicionarContacto()"
                                        x-show="index === contactos.length - 1"
                                        class="px-3 py-2 bg-accent/10 text-accent rounded-lg hover:bg-accent/20 transition-all">
                                    <i data-lucide="plus" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                    <p class="text-xs text-muted-foreground mt-1.5">Pode adicionar múltiplos contactos</p>
                </div>

                <div>
                    <label class="text-sm font-semibold text-foreground mb-1.5 block">
                        Observações <span class="text-muted-foreground font-normal">(opcional)</span>
                    </label>
                    <textarea x-model="observacoes" placeholder="Se tem alguma dúvida ou observação, deixe aqui..." 
                              class="input-field" rows="3"></textarea>
                </div>

                <label class="flex items-start gap-3 cursor-pointer group p-3 rounded-xl hover:bg-muted/50 transition-colors border border-transparent hover:border-border">
                    <input type="checkbox" x-model="termos" required
                           class="h-4 w-4 rounded border border-input text-primary focus:ring-2 focus:ring-ring mt-0.5 shrink-0 cursor-pointer">
                    <span class="text-sm text-muted-foreground leading-relaxed group-hover:text-foreground transition-colors">
                        Concordo em receber informações sobre cursos e promoções da MC-COMERCIAL <span class="text-destructive">*</span>
                    </span>
                </label>

                <div class="flex gap-3 pt-2">
                    <button type="button" @click="closeModal()"
                            class="btn-ghost flex-1 h-12 rounded-xl text-sm">
                        Cancelar
                    </button>
                    <button type="submit" :disabled="!canSubmit()"
                            class="btn-primary flex-[2] h-12 rounded-xl text-sm disabled:opacity-40 disabled:cursor-not-allowed disabled:transform-none">
                        <span x-show="!loading" class="flex items-center gap-2">
                            <i data-lucide="send" class="w-4 h-4"></i>Confirmar
                        </span>
                        <span x-show="loading" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            A enviar...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
