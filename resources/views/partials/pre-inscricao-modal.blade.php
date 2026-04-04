{{-- ═══════════════════════════════════════
     PRÉ-INSCRIÇÃO MODAL
     ═══════════════════════════════════════ --}}
<div x-data="{
    open: false,
    turmaId: null,
    turmaNome: '',
    nome_completo: '', email: '', contactos: [''], observacoes: '', termos: false,
    loading: false, success: false, errors: {},
    validEmail() { return !this.email || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email); },
    canSubmit() {
        return this.nome_completo.trim().length >= 2 && this.contactos.some(c => c.trim().length > 0) && this.termos && !this.loading;
    },
    openModal(detail) {
        this.turmaId = detail.turmaId; this.turmaNome = detail.turmaNome;
        this.nome_completo = ''; this.email = ''; this.contactos = [''];
        this.observacoes = ''; this.termos = false; this.loading = false;
        this.success = false; this.errors = {};
        this.open = true; document.body.style.overflow = 'hidden';
    },
    closeModal() { this.open = false; document.body.style.overflow = ''; },
    addContact() { this.contactos.push(''); },
    removeContact(i) { if (this.contactos.length > 1) this.contactos.splice(i, 1); },
    async submit() {
        this.loading = true; this.errors = {};
        try {
            const res = await fetch('/api/pre-inscricoes', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                body: JSON.stringify({
                    turma_id: this.turmaId, nome_completo: this.nome_completo,
                    email: this.email, contactos: this.contactos.filter(c => c.trim()),
                    observacoes: this.observacoes
                })
            });
            if (!res.ok) { const d = await res.json(); this.errors = d.errors || {}; this.loading = false; return; }
            this.success = true; this.loading = false;
            setTimeout(() => this.closeModal(), 3000);
            if (typeof showToast === 'function') showToast('Pré-inscrição enviada com sucesso!', 'success');
        } catch(e) { this.loading = false; if (typeof showToast === 'function') showToast('Erro ao enviar. Tente novamente.', 'error'); }
    }
}"
@open-pre-inscricao.window="openModal($event.detail)"
>
    {{-- Backdrop --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="closeModal()"
         class="fixed inset-0 z-[150] bg-slate-950/50 backdrop-blur-sm"
         x-cloak>
    </div>

    {{-- Panel --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-8 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[151] flex items-center justify-center p-4"
         x-cloak>
        <div @click.stop class="bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            {{-- Header --}}
            <div class="flex items-center justify-between p-6 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Pré-Inscrição</h3>
                    <p class="text-sm text-slate-500 mt-0.5" x-text="turmaNome"></p>
                </div>
                <button @click="closeModal()" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center transition-colors">
                    <i data-lucide="x" class="w-4 h-4 text-slate-500"></i>
                </button>
            </div>

            {{-- Success State --}}
            <template x-if="success">
                <div class="p-10 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-100 flex items-center justify-center mx-auto mb-5">
                        <i data-lucide="check-circle-2" class="w-8 h-8 text-emerald-600"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 mb-2">Inscrição Enviada!</h4>
                    <p class="text-sm text-slate-500">Entraremos em contacto em breve.</p>
                </div>
            </template>

            {{-- Form --}}
            <template x-if="!success">
                <form @submit.prevent="submit()" class="p-6 space-y-5">
                    {{-- Nome --}}
                    <div>
                        <label class="form-label">Nome Completo <span class="text-red-500">*</span></label>
                        <input x-model="nome_completo" type="text" class="form-input" placeholder="O seu nome completo" required>
                        <template x-if="errors.nome_completo"><p class="text-xs text-red-500 mt-1" x-text="errors.nome_completo[0]"></p></template>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="form-label">Email</label>
                        <input x-model="email" type="email" class="form-input" placeholder="email@exemplo.com"
                               :class="!validEmail() && 'border-red-400 focus:border-red-400 focus:ring-red-400/20'">
                    </div>

                    {{-- Contactos --}}
                    <div>
                        <label class="form-label">Contacto(s) <span class="text-red-500">*</span></label>
                        <template x-for="(c, i) in contactos" :key="i">
                            <div class="flex gap-2 mb-2">
                                <input x-model="contactos[i]" type="tel" class="form-input" placeholder="+244 9XX XXX XXX">
                                <button x-show="contactos.length > 1" @click="removeContact(i)" type="button"
                                        class="w-10 h-10 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 flex items-center justify-center shrink-0 transition-colors">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>
                        </template>
                        <button @click="addContact()" type="button" class="text-xs text-brand-600 hover:text-brand-700 font-medium flex items-center gap-1">
                            <i data-lucide="plus" class="w-3 h-3"></i> Adicionar contacto
                        </button>
                    </div>

                    {{-- Observações --}}
                    <div>
                        <label class="form-label">Observações</label>
                        <textarea x-model="observacoes" class="form-input h-20 resize-none" placeholder="Alguma informação adicional..."></textarea>
                    </div>

                    {{-- Termos --}}
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input x-model="termos" type="checkbox"
                               class="mt-0.5 w-4 h-4 rounded border-slate-300 text-brand-600 focus:ring-brand-600/30">
                        <span class="text-xs text-slate-500">Aceito os <a href="#" class="text-brand-600 underline">termos e condições</a> e a <a href="#" class="text-brand-600 underline">política de privacidade</a>.</span>
                    </label>

                    {{-- Submit --}}
                    <button type="submit" :disabled="!canSubmit()"
                            class="btn-primary w-full justify-center btn-lg"
                            :class="!canSubmit() && 'opacity-50 cursor-not-allowed'">
                        <template x-if="loading">
                            <svg class="animate-spin w-4 h-4" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        </template>
                        <span x-text="loading ? 'A enviar...' : 'Enviar Pré-Inscrição'"></span>
                    </button>
                </form>
            </template>
        </div>
    </div>
</div>
