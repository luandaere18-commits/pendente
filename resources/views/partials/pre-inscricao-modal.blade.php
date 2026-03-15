{{-- Modal de Pré-Inscrição --}}
<div x-data="{
    open: false,
    turmaId: null,
    turmaNome: '',
    nome: '', email: '', telefone: '', termos: false,
    loading: false,
    success: false,
    errors: {},
    validEmail() { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email); },
    canSubmit() { return this.nome.trim().length >= 2 && this.validEmail() && this.termos && !this.loading; },
    openModal(detail) {
        this.turmaId = detail.turmaId;
        this.turmaNome = detail.turmaNome;
        this.nome = ''; this.email = ''; this.telefone = '';
        this.termos = false; this.loading = false; this.success = false; this.errors = {};
        this.open = true;
        document.body.style.overflow = 'hidden';
    },
    closeModal() {
        this.open = false;
        document.body.style.overflow = '';
    },
    async submitForm() {
        if (!this.canSubmit()) return;
        this.loading = true;
        try {
            const r = await fetch('/api/pre-inscricoes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']')?.content
                },
                body: JSON.stringify({ turma_id: this.turmaId, nome: this.nome, email: this.email, telefone: this.telefone, termos: this.termos })
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
         class="absolute inset-0 bg-foreground/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    {{-- Dialog --}}
    <div class="relative z-10 w-full max-w-md bg-card rounded-2xl shadow-2xl overflow-hidden"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-90 translate-y-4">

        {{-- Header --}}
        <div class="bg-gradient-to-br from-primary to-primary/80 px-6 py-5 text-primary-foreground">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <i data-lucide="pen-line" class="w-5 h-5 opacity-80"></i>
                        <h2 class="text-lg font-bold">Pré-Inscrição</h2>
                    </div>
                    <p class="text-sm opacity-75" x-text="turmaNome"></p>
                </div>
                <button @click="closeModal()" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        {{-- Success state --}}
        <div x-show="success" class="px-6 py-12 text-center">
            <div class="w-16 h-16 rounded-full bg-success/10 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="check-circle-2" class="w-8 h-8 text-success"></i>
            </div>
            <h3 class="text-lg font-bold text-foreground mb-2">Inscrição Recebida!</h3>
            <p class="text-sm text-muted-foreground">Entraremos em contacto em breve para confirmar a sua inscrição.</p>
        </div>

        {{-- Form --}}
        <div x-show="!success" class="px-6 py-5">
            <form @submit.prevent="submitForm()" class="space-y-4">
                <div>
                    <label class="text-sm font-semibold text-foreground mb-1.5 block">
                        Nome Completo <span class="text-destructive">*</span>
                    </label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground"></i>
                        <input type="text" x-model="nome" placeholder="Seu nome completo" required
                               class="flex h-11 w-full rounded-xl border pl-10 pr-3 py-2 text-sm bg-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring transition-all"
                               :class="nome && nome.length < 2 ? 'border-destructive focus:ring-destructive/30' : 'border-input'">
                    </div>
                    <p class="text-xs text-destructive mt-1" x-show="nome && nome.length < 2">Nome muito curto</p>
                </div>

                <div>
                    <label class="text-sm font-semibold text-foreground mb-1.5 block">
                        Email <span class="text-destructive">*</span>
                    </label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground"></i>
                        <input type="email" x-model="email" placeholder="seuemail@exemplo.com" required
                               class="flex h-11 w-full rounded-xl border pl-10 pr-3 py-2 text-sm bg-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring transition-all"
                               :class="email && !validEmail() ? 'border-destructive focus:ring-destructive/30' : 'border-input'">
                    </div>
                    <p class="text-xs text-destructive mt-1" x-show="email && !validEmail()">Endereço de email inválido</p>
                </div>

                <div>
                    <label class="text-sm font-semibold text-foreground mb-1.5 block">Telefone <span class="text-muted-foreground font-normal">(opcional)</span></label>
                    <div class="relative">
                        <i data-lucide="phone" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground"></i>
                        <input type="text" x-model="telefone" placeholder="+244 9XX-XXX-XXX"
                               class="flex h-11 w-full rounded-xl border border-input pl-10 pr-3 py-2 text-sm bg-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring transition-all">
                    </div>
                </div>

                <label class="flex items-start gap-3 cursor-pointer group p-3 rounded-xl hover:bg-muted/50 transition-colors">
                    <input type="checkbox" x-model="termos" required
                           class="h-4 w-4 rounded border border-input text-primary focus:ring-2 focus:ring-ring mt-0.5 shrink-0 cursor-pointer">
                    <span class="text-sm text-muted-foreground leading-relaxed group-hover:text-foreground transition-colors">
                        Concordo em receber informações sobre cursos e promoções da MC-COMERCIAL <span class="text-destructive">*</span>
                    </span>
                </label>

                <div class="flex gap-2 pt-2">
                    <button type="button" @click="closeModal()"
                            class="flex-1 h-11 rounded-xl text-sm font-semibold border border-input bg-background hover:bg-muted transition-all duration-200">
                        Cancelar
                    </button>
                    <button type="submit" :disabled="!canSubmit()"
                            class="flex-2 flex-grow-[2] h-11 rounded-xl text-sm font-semibold bg-primary text-primary-foreground hover:bg-primary/90 active:scale-95 transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed disabled:scale-100 flex items-center justify-center gap-2">
                        <span x-show="!loading">
                            <i data-lucide="send" class="w-4 h-4 inline mr-1"></i>Confirmar Inscrição
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
