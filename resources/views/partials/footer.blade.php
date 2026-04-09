{{-- ═══════════════════════════════════════
     FOOTER — Modern Dark with Animations
     ═══════════════════════════════════════ --}}
<footer class="bg-gradient-to-b from-slate-900 to-slate-950 text-white relative overflow-hidden">
    {{-- Decorative Elements --}}
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-brand-400/50 to-transparent"></div>
    <div class="absolute top-0 right-0 w-[600px] h-[600px] rounded-full bg-brand-500/5 blur-[150px] -translate-y-1/2"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full bg-brand-600/5 blur-[120px] translate-y-1/2"></div>

    {{-- Newsletter --}}
    <div class="container-wide relative py-16 border-b border-white/10">
        <div class="max-w-2xl mx-auto text-center reveal">
            <span class="badge-gold mb-4">
                <i data-lucide="bell" class="w-3 h-3"></i>
                Newsletter
            </span>
            <h3 class="text-2xl sm:text-3xl font-bold tracking-tight mb-3 font-heading">Fique a par das novidades</h3>
            <p class="text-slate-400 text-sm mb-8">Receba informações sobre novos cursos, turmas e eventos directamente no seu email.</p>
            <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                <input type="email" placeholder="O seu email..." class="flex-1 px-5 py-3.5 rounded-xl bg-white/10 border border-white/10 text-white placeholder:text-slate-500 focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/20 transition-all text-sm">
                <button type="submit" class="btn-primary btn-lg whitespace-nowrap">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    Subscrever
                </button>
            </form>
        </div>
    </div>

    <div class="container-wide relative">
        {{-- Main Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 py-16">
            {{-- Brand --}}
            <div class="lg:col-span-1 reveal">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand-600 to-brand-700 flex items-center justify-center shadow-lg">
                        <img src="{{ asset('images/logo.png') }}" alt="MC-COMERCIAL" class="h-8 w-8 object-contain"
                             onerror="this.parentElement.innerHTML='<span class=\'text-white font-black text-lg\'>MC</span>'">
                    </div>
                    <div>
                        <span class="text-lg font-extrabold block font-heading">MC-COMERCIAL</span>
                        <span class="text-[10px] text-brand-300 uppercase tracking-[0.2em]">Formação Profissional</span>
                    </div>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed mb-8 max-w-xs">
                    Centro de formação de qualidade com mais de 10 anos de experiência na preparação de profissionais para o mercado angolano.
                </p>
                <div class="flex gap-3">
                    @foreach([
                        ['icon' => 'facebook', 'url' => '#', 'color' => 'hover:bg-blue-600'],
                        ['icon' => 'instagram', 'url' => '#', 'color' => 'hover:bg-gradient-to-br hover:from-purple-500 hover:to-pink-500'],
                        ['icon' => 'linkedin', 'url' => '#', 'color' => 'hover:bg-blue-700'],
                        ['icon' => 'youtube', 'url' => '#', 'color' => 'hover:bg-red-600'],
                    ] as $social)
                        <a href="{{ $social['url'] }}" class="w-10 h-10 rounded-xl bg-white/10 text-slate-400 hover:text-white
                                          flex items-center justify-center transition-all duration-300 hover:scale-110 {{ $social['color'] }}">
                            <i data-lucide="{{ $social['icon'] }}" class="w-4 h-4"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Links --}}
            <div class="reveal">
                <h4 class="text-sm font-bold text-white mb-6 uppercase tracking-wider font-heading">Navegação</h4>
                <ul class="space-y-3">
                    @foreach([
                        ['Início', 'site.home'], ['Centros', 'site.centros'], ['Turmas', 'site.cursos'],
                        ['Serviços', 'site.servicos'], ['Loja', 'site.loja'], ['Sobre Nós', 'site.sobre']
                    ] as [$label, $route])
                        <li>
                            <a href="{{ route($route) }}" class="text-sm text-slate-400 hover:text-brand-300 transition-all duration-300 flex items-center gap-2 group">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-600 group-hover:bg-brand-400 group-hover:scale-150 transition-all duration-300"></span>
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact --}}
            <div class="reveal">
                <h4 class="text-sm font-bold text-white mb-6 uppercase tracking-wider font-heading">Contactos</h4>
                <ul class="space-y-4">
                    @foreach([
                        ['icon' => 'mail', 'label' => 'Email', 'value' => 'info@mc-comercial.co.ao'],
                        ['icon' => 'phone', 'label' => 'Telefone', 'value' => '+244 923 000 000'],
                        ['icon' => 'map-pin', 'label' => 'Morada', 'value' => 'Luanda, Angola'],
                    ] as $contact)
                        <li class="flex items-start gap-3 group">
                            <div class="w-9 h-9 rounded-lg bg-white/10 group-hover:bg-brand-600 flex items-center justify-center shrink-0 mt-0.5 transition-all duration-300">
                                <i data-lucide="{{ $contact['icon'] }}" class="w-4 h-4 text-brand-300 group-hover:text-white transition-colors"></i>
                            </div>
                            <div>
                                <span class="text-xs text-slate-500 block">{{ $contact['label'] }}</span>
                                <span class="text-sm text-slate-300">{{ $contact['value'] }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Schedule --}}
            <div class="reveal">
                <h4 class="text-sm font-bold text-white mb-6 uppercase tracking-wider font-heading">Horário</h4>
                <div class="space-y-3">
                    @foreach([
                        ['Segunda - Sexta', '08:00 — 17:00'],
                        ['Sábado', '08:00 — 13:00'],
                        ['Domingo', 'Encerrado'],
                    ] as [$day, $time])
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400">{{ $day }}</span>
                            <span class="text-slate-300 font-medium">{{ $time }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 p-4 rounded-xl bg-brand-600/10 border border-brand-500/20">
                    <p class="text-xs text-brand-300 flex items-center gap-2">
                        <i data-lucide="info" class="w-3.5 h-3.5 shrink-0"></i>
                        Inscrições abertas durante todo o ano
                    </p>
                </div>
            </div>
        </div>

        {{-- Bottom --}}
        <div class="py-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-slate-500">© {{ date('Y') }} MC-COMERCIAL. Todos os direitos reservados.</p>
            <div class="flex gap-6">
                <a href="#" class="text-xs text-slate-500 hover:text-brand-300 transition-colors">Termos & Condições</a>
                <a href="#" class="text-xs text-slate-500 hover:text-brand-300 transition-colors">Privacidade</a>
            </div>
        </div>
    </div>
</footer>
