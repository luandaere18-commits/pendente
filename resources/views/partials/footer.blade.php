{{-- Rodapé --}}
<footer class="bg-footer text-footer-foreground pt-20 pb-8 relative overflow-hidden">
    {{-- Decorative blurs --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-32 -right-32 w-[500px] h-[500px] rounded-full opacity-[0.04]" style="background: hsl(var(--accent)); filter: blur(120px);"></div>
        <div class="absolute -bottom-32 -left-32 w-[400px] h-[400px] rounded-full opacity-[0.03]" style="background: hsl(var(--primary)); filter: blur(100px);"></div>
    </div>

    <div class="container mx-auto px-4 relative">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">

            {{-- Col 1 - Sobre --}}
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center p-1.5" style="box-shadow: var(--shadow-md);">
                        <img src="{{ asset('images/logo.png') }}" alt="MC-COMERCIAL" class="h-full w-full object-contain"
                             onerror="this.parentElement.innerHTML='<span class=\'text-primary font-black text-base\'>MC</span>'">
                    </div>
                    <div>
                        <span class="text-base font-extrabold text-white block leading-tight tracking-tight">MC-COMERCIAL</span>
                        <span class="text-[10px] opacity-50 uppercase tracking-[0.2em]">Centro de Formação</span>
                    </div>
                </div>
                <p class="text-sm opacity-50 mb-8 leading-relaxed">
                    Centro de formação de qualidade com mais de 10 anos de experiência na preparação de profissionais qualificados para o mercado de trabalho angolano.
                </p>
                <div class="flex gap-2">
                    @foreach([
                        ['icon' => 'facebook',  'href' => '#'],
                        ['icon' => 'instagram', 'href' => '#'],
                        ['icon' => 'linkedin',  'href' => '#'],
                        ['icon' => 'youtube',   'href' => '#'],
                    ] as $social)
                        <a href="{{ $social['href'] }}"
                           class="w-10 h-10 rounded-xl bg-white/6 flex items-center justify-center hover:bg-accent hover:scale-110 transition-all duration-300 border border-white/5 hover:border-accent"
                           aria-label="{{ $social['icon'] }}">
                            <i data-lucide="{{ $social['icon'] }}" class="w-4 h-4"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Col 2 - Links --}}
            <div>
                <h4 class="font-bold text-white mb-6 flex items-center gap-2.5">
                    <span class="w-1.5 h-5 rounded-full" style="background: var(--gradient-accent);"></span>
                    Links Rápidos
                </h4>
                <ul class="space-y-3 text-sm">
                    @php
                        $footerLinks = [
                            ['label' => 'Home',      'route' => 'site.home'],
                            ['label' => 'Centros',   'route' => 'site.centros'],
                            ['label' => 'Turmas',    'route' => 'site.cursos'],
                            ['label' => 'Serviços',  'route' => 'site.servicos'],
                            ['label' => 'Loja',      'route' => 'site.loja'],
                            ['label' => 'Sobre Nós', 'route' => 'site.sobre'],
                            ['label' => 'Contactos', 'route' => 'site.contactos'],
                        ];
                    @endphp
                    @foreach($footerLinks as $link)
                        <li>
                            <a href="{{ route($link['route']) }}"
                               class="flex items-center gap-2 opacity-50 hover:opacity-100 hover:text-accent hover:translate-x-2 transition-all duration-300">
                                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Col 3 - Contactos --}}
            <div>
                <h4 class="font-bold text-white mb-6 flex items-center gap-2.5">
                    <span class="w-1.5 h-5 rounded-full" style="background: var(--gradient-accent);"></span>
                    Contactos
                </h4>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-accent/15 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="phone" class="w-4 h-4 text-accent"></i>
                        </div>
                        <div>
                            <a href="tel:+244926861700" class="block opacity-60 hover:opacity-100 hover:text-accent transition-all duration-200">+244 926-861-700</a>
                            <a href="tel:+244926861700" class="block opacity-60 hover:opacity-100 hover:text-accent transition-all duration-200">+244 926-861-700</a>
                        </div>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-accent/15 flex items-center justify-center shrink-0">
                            <i data-lucide="mail" class="w-4 h-4 text-accent"></i>
                        </div>
                        <a href="mailto:mc-comercial@gmail.com" class="opacity-60 hover:opacity-100 hover:text-accent transition-all duration-200 break-all">
                            mc-comercial@gmail.com
                        </a>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-accent/15 flex items-center justify-center shrink-0 mt-0.5">
                            <i data-lucide="map-pin" class="w-4 h-4 text-accent"></i>
                        </div>
                        <span class="opacity-60 leading-relaxed">Rua A, Bairro 1º de Maio Nº 05, 1º Andar, Luanda-Viana</span>
                    </li>
                </ul>
            </div>

            {{-- Col 4 - Horário --}}
            <div>
                <h4 class="font-bold text-white mb-6 flex items-center gap-2.5">
                    <span class="w-1.5 h-5 rounded-full" style="background: var(--gradient-accent);"></span>
                    Horário
                </h4>
                <ul class="space-y-3 text-sm mb-8">
                    <li class="flex items-center justify-between py-2.5 border-b border-white/8 rounded-lg px-3 hover:bg-white/3 transition-colors">
                        <span class="opacity-50">Segunda - Sexta</span>
                        <span class="font-semibold text-white tabular-nums">8h00 - 18h00</span>
                    </li>
                    <li class="flex items-center justify-between py-2.5 border-b border-white/8 rounded-lg px-3 hover:bg-white/3 transition-colors">
                        <span class="opacity-50">Sábado</span>
                        <span class="font-semibold text-white tabular-nums">9h00 - 16h00</span>
                    </li>
                    <li class="flex items-center justify-between py-2.5 rounded-lg px-3 hover:bg-white/3 transition-colors">
                        <span class="opacity-50">Domingo</span>
                        <span class="text-red-400 font-semibold">Encerrado</span>
                    </li>
                </ul>
                <a href="https://wa.me/244929643510?text=Ol%C3%A1%2C%20gostaria%20de%20saber%20mais%20sobre%20os%20cursos"
                   target="_blank" rel="noopener noreferrer"
                   class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl text-sm font-bold transition-all duration-300 hover:scale-105 hover:shadow-lg"
                   style="background-color: #25D366; color: white;">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    Contactar via WhatsApp
                </a>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-white/8 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm opacity-40">
            <span>&copy; {{ date('Y') }} MC-COMERCIAL. Todos os direitos reservados.</span>
            <div class="flex items-center gap-6">
                <a href="#" class="hover:opacity-100 hover:text-accent transition-all duration-200">Política de Privacidade</a>
                <a href="#" class="hover:opacity-100 hover:text-accent transition-all duration-200">Termos de Uso</a>
            </div>
        </div>
    </div>
</footer>
