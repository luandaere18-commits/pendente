{{-- ═══════════════════════════════════════
     FOOTER — Blue & White Modern
     ═══════════════════════════════════════ --}}
<footer class="bg-brand-950 text-white relative overflow-hidden">
    {{-- Decorative --}}
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-brand-400/40 to-transparent"></div>
    <div class="absolute top-0 right-0 w-[600px] h-[600px] rounded-full bg-brand-500/5 blur-[120px] -translate-y-1/2"></div>

    <div class="container-wide relative">
        {{-- Main Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 py-20">
            {{-- Brand --}}
            <div class="lg:col-span-1">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-11 h-11 rounded-xl bg-brand-600 flex items-center justify-center">
                        <img src="{{ asset('images/logo.png') }}" alt="MC-COMERCIAL" class="h-7 w-7 object-contain"
                             onerror="this.parentElement.innerHTML='<span class=\'text-white font-black text-sm\'>MC</span>'">
                    </div>
                    <div>
                        <span class="text-base font-bold block">MC-COMERCIAL</span>
                        <span class="text-[10px] text-brand-300 uppercase tracking-widest">Formação Profissional</span>
                    </div>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed mb-8 max-w-xs">
                    Centro de formação de qualidade com mais de 10 anos de experiência na preparação de profissionais para o mercado angolano.
                </p>
                <div class="flex gap-2">
                    @foreach(['facebook', 'instagram', 'linkedin'] as $social)
                        <a href="#" class="w-9 h-9 rounded-lg bg-white/10 hover:bg-brand-500 text-slate-400 hover:text-white
                                          flex items-center justify-center transition-all duration-200 hover:scale-110">
                            <i data-lucide="{{ $social }}" class="w-4 h-4"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Links --}}
            <div>
                <h4 class="text-sm font-semibold text-white mb-5 uppercase tracking-wider">Navegação</h4>
                <ul class="space-y-3">
                    @foreach([
                        ['Início', 'site.home'], ['Centros', 'site.centros'], ['Turmas', 'site.cursos'],
                        ['Serviços', 'site.servicos'], ['Loja', 'site.loja'], ['Sobre Nós', 'site.sobre']
                    ] as [$label, $route])
                        <li>
                            <a href="{{ route($route) }}" class="text-sm text-slate-400 hover:text-brand-300 transition-colors duration-200 flex items-center gap-2 group">
                                <span class="w-1 h-1 rounded-full bg-slate-600 group-hover:bg-brand-400 transition-colors"></span>
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="text-sm font-semibold text-white mb-5 uppercase tracking-wider">Contactos</h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="mail" class="w-3.5 h-3.5 text-brand-300"></i>
                        </div>
                        <div>
                            <span class="text-xs text-slate-500 block">Email</span>
                            <a href="mailto:mc-comercial@gmail.com" class="text-sm text-slate-300 hover:text-white transition-colors">mc-comercial@gmail.com</a>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="phone" class="w-3.5 h-3.5 text-brand-300"></i>
                        </div>
                        <div>
                            <span class="text-xs text-slate-500 block">Telefone</span>
                            <a href="tel:+244926861700" class="text-sm text-slate-300 hover:text-white transition-colors">+244 926 861 700</a>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-brand-300"></i>
                        </div>
                        <div>
                            <span class="text-xs text-slate-500 block">Horário</span>
                            <span class="text-sm text-slate-300">Seg - Sex: 8h00 - 18h00</span>
                        </div>
                    </li>
                </ul>
            </div>

            {{-- Newsletter --}}
            <div>
                <h4 class="text-sm font-semibold text-white mb-5 uppercase tracking-wider">Newsletter</h4>
                <p class="text-sm text-slate-400 mb-4">Receba novidades sobre cursos e formações.</p>
                <form class="space-y-3">
                    @csrf
                    <input type="email" placeholder="O seu email" class="w-full px-4 py-2.5 rounded-xl bg-white/10 border border-white/10 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-400 focus:ring-1 focus:ring-brand-400/30 transition-all">
                    <button type="submit" class="btn-primary w-full justify-center btn-sm">
                        Subscrever
                    </button>
                </form>
            </div>
        </div>

        {{-- Bottom --}}
        <div class="border-t border-white/10 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-slate-500">&copy; {{ date('Y') }} MC-COMERCIAL. Todos os direitos reservados.</p>
            <div class="flex items-center gap-4">
                <a href="#" class="text-xs text-slate-500 hover:text-slate-300 transition-colors">Termos</a>
                <a href="#" class="text-xs text-slate-500 hover:text-slate-300 transition-colors">Privacidade</a>
            </div>
        </div>
    </div>
</footer>
