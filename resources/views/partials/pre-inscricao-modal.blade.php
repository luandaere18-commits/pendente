{{-- Modal de Pré-Inscrição --}}
<div x-data="{ 
    open: false,
    turmaId: null,
    turmaNome: '',
    nome: '', email: '', telefone: '', termos: false,
    loading: false,
    validEmail() { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email); },
    canSubmit() { return this.nome && this.validEmail() && this.termos; },
    openModal(detail) {
        this.turmaId = detail.turmaId;
        this.turmaNome = detail.turmaNome;
        this.nome = '';
        this.email = '';
        this.telefone = '';
        this.termos = false;
        this.open = true;
    }
}" x-show="open" x-cloak
     @pre-inscricao.window="openModal($event.detail)"
     class="fixed inset-0 z-50 flex items-center justify-center p-4">

    {{-- Overlay --}}
    <div @click="open = false" class="absolute inset-0 bg-foreground/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"></div>

    {{-- Content --}}
    <div class="relative bg-card rounded-2xl p-6 md:p-8 max-w-md w-full"
         style="box-shadow: var(--shadow-card-hover);"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">

        {{-- Close --}}
        <button @click="open = false" class="absolute right-4 top-4 text-muted-foreground hover:text-foreground">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <h2 class="text-xl font-bold text-foreground mb-2">Pré-Inscrição</h2>
        <p class="text-sm text-muted-foreground mb-6" x-text="turmaNome"></p>

        <form @submit.prevent="
            if (!canSubmit()) return;
            loading = true;
            fetch('/api/pre-inscricoes', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]')?.content },
                body: JSON.stringify({ turma_id: turmaId, nome, email, telefone, termos })
            }).then(r => {
                if (r.ok) {
                    open = false;
                    alert('Pré-inscrição realizada com sucesso!');
                } else {
                    alert('Erro ao enviar. Tente novamente.');
                }
            }).catch(() => alert('Erro de conexão.')).finally(() => loading = false);
        " class="space-y-4">
            @csrf

            <div>
                <label for="modal-nome" class="text-sm font-medium text-foreground mb-1 block">Nome Completo *</label>
                <input id="modal-nome" type="text" x-model="nome" placeholder="Seu nome completo"
                       required
                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring">
            </div>

            <div>
                <label for="modal-email" class="text-sm font-medium text-foreground mb-1 block">Email *</label>
                <input id="modal-email" type="email" x-model="email" placeholder="seuemail@exemplo.com"
                       required
                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring">
                <p class="text-xs text-destructive mt-1" x-show="email && !validEmail()">Email inválido</p>
            </div>

            <div>
                <label for="modal-telefone" class="text-sm font-medium text-foreground mb-1 block">Telefone (opcional)</label>
                <input id="modal-telefone" type="text" x-model="telefone" placeholder="+244 9XX-XXX-XXX"
                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring">
            </div>

            <div class="flex items-start gap-2">
                <input id="modal-termos" type="checkbox" x-model="termos"
                       class="h-4 w-4 rounded border border-input text-primary focus:ring-2 focus:ring-ring mt-1">
                <label for="modal-termos" class="text-sm text-foreground">Concordo em receber informações sobre cursos e promoções *</label>
            </div>

            <div class="flex gap-2 justify-end pt-4">
                <button type="button" @click="open = false"
                        class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-input bg-background h-10 px-4 hover:bg-muted transition-colors">
                    Cancelar
                </button>
                <button type="submit" :disabled="!canSubmit() || loading"
                        class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground h-10 px-4 hover:bg-primary/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">Inscrever-se</span>
                    <span x-show="loading">Enviando...</span>
                </button>
            </div>
        </form>
    </div>
</div>
