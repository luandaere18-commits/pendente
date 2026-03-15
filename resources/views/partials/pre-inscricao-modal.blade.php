{{-- Modal de Pré-Inscrição --}}
<div x-data="preInscricaoModal()" x-show="open" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center"
     @pre-inscricao.window="openModal($event.detail)">

    {{-- Overlay --}}
    <div class="fixed inset-0 bg-black/80" @click="open = false"></div>

    {{-- Content --}}
    <div class="relative z-10 w-full max-w-md bg-background border rounded-lg p-6 shadow-lg mx-4"
         x-show="open" x-transition>

        {{-- Close --}}
        <button @click="open = false" class="absolute right-4 top-4 opacity-70 hover:opacity-100">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>

        <h2 class="text-lg font-semibold mb-1">Pré-Inscrição</h2>
        <p class="text-sm text-muted-foreground mb-4" x-text="turmaNome"></p>

        <form @submit.prevent="submitForm" class="space-y-4">
            @csrf
            <input type="hidden" x-model="turmaId">

            <div>
                <label for="modal-nome" class="text-sm font-medium text-foreground mb-1 block">Nome Completo *</label>
                <input id="modal-nome" type="text" x-model="form.nome" placeholder="Seu nome completo"
                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
            </div>

            <div>
                <label for="modal-email" class="text-sm font-medium text-foreground mb-1 block">Email *</label>
                <input id="modal-email" type="email" x-model="form.email" placeholder="seuemail@exemplo.com"
                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
            </div>

            <div>
                <label for="modal-telefone" class="text-sm font-medium text-foreground mb-1 block">Telefone</label>
                <input id="modal-telefone" type="text" x-model="form.telefone" placeholder="+244 9XX-XXX-XXX"
                       class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
            </div>

            <div class="flex items-center gap-2">
                <input id="modal-termos" type="checkbox" x-model="form.termos"
                       class="h-4 w-4 rounded border-primary text-primary focus:ring-primary">
                <label for="modal-termos" class="text-sm">Concordo com os termos e condições *</label>
            </div>

            <div class="flex gap-2 justify-end">
                <button type="button" @click="open = false"
                        class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-input bg-background h-10 px-4 hover:bg-accent hover:text-accent-foreground">
                    Cancelar
                </button>
                <button type="submit" :disabled="loading"
                        class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground h-10 px-4 hover:bg-primary/90 disabled:opacity-50">
                    <span x-show="!loading">Inscrever-se</span>
                    <span x-show="loading">Enviando...</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function preInscricaoModal() {
    return {
        open: false,
        turmaId: null,
        turmaNome: '',
        loading: false,
        form: { nome: '', email: '', telefone: '', termos: false },

        openModal(detail) {
            this.turmaId = detail.turmaId;
            this.turmaNome = detail.turmaNome;
            this.form = { nome: '', email: '', telefone: '', termos: false };
            this.open = true;
        },

        async submitForm() {
            if (!this.form.nome.trim()) return showToast('Nome é obrigatório', 'error');
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.email)) return showToast('Email inválido', 'error');
            if (!this.form.termos) return showToast('Deve aceitar os termos', 'error');

            this.loading = true;
            try {
                const response = await fetch('/api/pre-inscricoes', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content },
                    body: JSON.stringify({ turma_id: this.turmaId, ...this.form })
                });
                if (response.ok) {
                    showToast('Pré-inscrição realizada com sucesso!');
                    this.open = false;
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
