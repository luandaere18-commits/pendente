{{-- ═══════════════════════════════════════
     MODAL DE PRÉ-INSCRIÇÃO
     ═══════════════════════════════════════ --}}
<div x-data="{ open: false, turmaId: null, turmaNome: '', loading: false, success: false }"
     @open-pre-inscricao.window="open = true; turmaId = $event.detail.turmaId || null; turmaNome = $event.detail.turmaNome || ''; success = false;"
     x-show="open"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4"
     style="background: hsl(224 58% 10% / 0.7); backdrop-filter: blur(8px);"
     x-cloak>

    {{-- Modal Card --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90 translate-y-4"
         @click.outside="open = false"
         class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden">

        {{-- Header --}}
        <div class="relative px-8 pt-8 pb-6" style="background: linear-gradient(135deg, hsl(210 88% 52% / 0.06), hsl(28 78% 56% / 0.04));">
            <button @click="open = false" class="absolute top-4 right-4 w-9 h-9 rounded-xl flex items-center justify-center hover:bg-slate-100 transition-colors" style="color: hsl(215 12% 62%);">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4" style="background: linear-gradient(135deg, hsl(210 88% 52%), hsl(215 82% 46%));">
                <i data-lucide="clipboard-list" class="w-6 h-6 text-white"></i>
            </div>
            <h3 class="text-xl font-bold" style="color: hsl(224 30% 12%); font-family: Outfit;">Pré-Inscrição</h3>
            <p class="text-sm mt-1" style="color: hsl(215 12% 55%);">Preencha os dados abaixo para garantir a sua vaga.</p>
            <template x-if="turmaNome">
                <div class="mt-3">
                    <span class="badge-brand text-xs">
                        <i data-lucide="graduation-cap" class="w-3 h-3"></i>
                        <span x-text="turmaNome"></span>
                    </span>
                </div>
            </template>
        </div>

        {{-- Form --}}
        <template x-if="!success">
            <form @submit.prevent="
                loading = true;
                const fd = new FormData($el);
                if (turmaId) fd.append('turma_id', turmaId);
                
                // Adicionar contactos como array (o telefone que foi enviado)
                const telefone = fd.get('contactos_telefone');
                if (telefone) {
                    fd.delete('contactos_telefone');
                    fd.append('contactos[]', telefone);
                }
                
                fetch('{{ route('api.pre-inscricoes.store') }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' },
                    body: fd
                })
                .then(r => r.json())
                .then(data => { 
                    if (data.status === 'sucesso') {
                        loading = false; 
                        success = true; 
                        showToast('Pré-inscrição enviada com sucesso!', 'success');
                    } else {
                        loading = false; 
                        showToast(data.mensagem || 'Erro ao enviar. Tente novamente.', 'error');
                    }
                })
                .catch(err => { 
                    loading = false; 
                    console.error('Erro:', err);
                    showToast('Erro ao enviar. Tente novamente.', 'error'); 
                });
            " class="px-8 pb-8 space-y-4">

                <div>
                    <label class="form-label">Nome Completo *</label>
                    <input type="text" name="nome_completo" required class="form-input" placeholder="Insira o seu nome completo">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" required class="form-input" placeholder="email@exemplo.com">
                    </div>
                    <div>
                        <label class="form-label">Telefone *</label>
                        <input type="tel" name="contactos_telefone" required class="form-input" placeholder="+244 ...">
                    </div>
                </div>
                <div>
                    <label class="form-label">Observações</label>
                    <textarea name="observacoes" rows="3" class="form-input resize-none" placeholder="Alguma informação adicional..."></textarea>
                </div>

                <button type="submit" class="btn-primary w-full btn-lg" :disabled="loading">
                    <template x-if="!loading">
                        <span class="flex items-center gap-2">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            Enviar Pré-Inscrição
                        </span>
                    </template>
                    <template x-if="loading">
                        <span class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none" opacity=".3"/><path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round"/></svg>
                            Enviando...
                        </span>
                    </template>
                </button>
            </form>
        </template>

        {{-- Success State --}}
        <template x-if="success">
            <div class="px-8 pb-8 text-center py-8">
                <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center" style="background: hsl(152 76% 94%);">
                    <i data-lucide="check-circle-2" class="w-8 h-8" style="color: hsl(152 60% 42%);"></i>
                </div>
                <h4 class="text-lg font-bold mb-2" style="color: hsl(224 30% 12%); font-family: Outfit;">Inscrição Enviada!</h4>
                <p class="text-sm mb-6" style="color: hsl(215 12% 55%);">Entraremos em contacto em breve. Obrigado pelo seu interesse!</p>
                <button @click="open = false" class="btn-primary">Fechar</button>
            </div>
        </template>
    </div>
</div>
